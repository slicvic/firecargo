<?php namespace App\Http\Controllers;

use Session;
use Validator;
use Event;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Site;
use App\Models\Role;
use App\Helpers\Html;
use Flash;
use App\Events\UserLoggedIn;
use App\Events\UserJoined;
use App\Helpers\Mailer;
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
     * @return Response
     */
    public function postLogin(Request $request)
    {
        $input = $request->only('email', 'password');

        // Validate input
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $this->validate($input, $rules);

        // Authenticate user
        $user = User::validateCredentials($input['email'], $input['password']);

        if ($user)
        {
            // Fire event
            Event::fire(new UserLoggedIn($user));
            return redirect('dashboard');
        }

        return $this->redirectBackWithError('These credentials do not match our records.');
    }

    /**
     * Shows the signup form.
     *
     * @return Response
     */
    public function getSignup()
    {
        return view('auth.signup');
    }

    /**
     * Signs up a new user.
     *
     * @return Response
     */
    public function postSignup(Request $request)
    {
        $input = $request->only('user');

        // Validate input
        $rules = [
            'site_id' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'first_name' => 'required',
            'last_name' => 'required'
        ];

        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Validate site ID
        if ( ! Site::find($input['user']['site_id']))
        {
            Flash::error('Your site ID is not valid.');
            return redirect()->back()->withInput();
        }

        // Create user
        $user = User::create($input['user']);
        $user->roles()->sync([Role::CLIENT, Role::LOGIN]);

        // Fire event
        Event::fire(new UserJoined($user));

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
     * @return Response
     */
    public function postForgotPassword(Request $request)
    {
        $input = $request->only('email');

        // Validate input
        $this->validate($input, ['email' => 'required|email']);

        // Verify user
        $user = User::where('email', '=', $input['email'])->first();

        // Send password recovery
        if ($user)
        {
            Mailer::sendPasswordRecovery($user);
            // TODO: change message
            // Show success message regardless
            // @TODO: uncomment
            //
            Flash::success('<a href="/reset-password?email=' . $user->email . '&token=' . $user->makePasswordRecoveryToken() . '">Click here to reset your password</a>');
            return redirect()->back();
            //return $this->redirectBackWithSuccess('An email with instructions on how to reset your password has been sent.');
        }

        return $this->redirectBackWithError('This email address is not associated with any account.');
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
     * @return Response
     */
    public function postResetPassword(Request $request)
    {
        $input = $request->only('email', 'token', 'password', 'confirm_password');

        // Validate input
        $rules = [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ];

        $this->validate($input, $rules);

        // Verify user
        $user = User::where('email', '=', $input['email'])->first();

        // Reset password
        if ($user && $user->verifyPasswordRecoveryToken($input['token']))
        {
            $user->password = $input['password'];
            $user->save();
            return $this->redirectWithSuccess('login', 'Your password was reset successfully.');
        }

        return $this->redirectBackWithError('Password reset failed.');
    }
}
