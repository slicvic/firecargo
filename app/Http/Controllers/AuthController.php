<?php namespace App\Http\Controllers;

use Validator;
use Event;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Address;
use App\Models\Company;
use Flash;
use App\Events\UserLoggedIn;
use App\Events\UserRegistered;
use App\Helpers\Mailer;
use App\Http\Requests\RegisterUserFormRequest;

/**
 * AuthController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AuthController extends BaseController {

    /**
     * Shows the login form.
     *
     * @return Response
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Logs in a user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postLogin(Request $request)
    {
        $input = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];

        // Validate input
        $this->validate($input, $rules);

        // Authenticate user
        $user = User::validateCredentials($input['email'], $input['password']);

        if ( ! $user)
        {
            return $this->redirectBackWithError('These credentials do not match our records.');
        }

        Event::fire(new UserLoggedIn($user));

        return redirect('/dashboard');
    }

    /**
     * Shows the signup form.
     *
     * @return Response
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * Registers a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postRegister(RegisterUserFormRequest $request)
    {
        $input = $request->all();

        $company = Company::where('referer_id', $input['ref_id'])->first();

        // Create user
        $user = new User;
        $user->company_id = $company->id;
        $user->firstname = $input['firstname'];
        $user->lastname = $input['lastname'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->active = TRUE;
        $user->role_id = Role::CUSTOMER;
        $user->save();

        // Create customer account
        $account = $user->account()->first();
        $account->phone = $input['phone'];
        $account->save();

        // Create customer account address
        $address = new Address;
        $address->address1 = $input['address1'];
        $address->address2 = $input['address2'];
        $address->city = $input['city'];
        $address->state = $input['state'];
        $address->postal_code = $input['postal_code'];
        $address->country_id = $input['country_id'];

        $account->address()->save($address);

        Event::fire(new UserRegistered($user));

        return redirect('dashboard');
    }

    /**
     * Shows the form for recovering a user's password.
     *
     * @return Response
     */
    public function getForgotPassword()
    {
        return view('auth.forgot_password');
    }

    /**
     * Sends a password recovery token to the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postForgotPassword(Request $request)
    {
        $input = $request->only('email');

        // Validate input
        $this->validate($input, ['email' => 'required|email']);

        // Verify user
        $user = User::where('email', $input['email'])->first();

        if ( ! $user)
        {
            return $this->redirectBackWithError('This email address is not associated with any account.');
        }

        // Send password recovery
        //Mailer::sendPasswordRecovery($user);
        // TODO: change message
        // Show success message regardless
        // @TODO: uncomment
        //
        //Flash::success('<a href="/reset-password?email=' . $user->email . '&token=' . $user->makePasswordRecoveryToken() . '">Click here to reset your password</a>');

        return $this->redirectBackWithSuccess('An email with instructions on how to reset your password has been sent.');
    }

    /**
     * Shows the form for resetting a user's password.
     *
     * @return Response
     */
    public function getResetPassword()
    {
        return view('auth.reset_password');
    }

    /**
     * Resets a user's password.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postResetPassword(Request $request)
    {
        $input = $request->only('email', 'token', 'password', 'confirm_password');

        $rules = [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ];

        // Validate input
        $this->validate($input, $rules);

        // Verify user
        $user = User::where('email', $input['email'])->first();

        if ( ! $user || ! $user->verifyPasswordRecoveryToken($input['token']))
        {
            return $this->redirectBackWithError('Password reset failed.');
        }

        // Reset password
        $user->password = $input['password'];
        $user->save();

        return $this->redirectWithSuccess('login', 'Your password was reset successfully.');
    }
}
