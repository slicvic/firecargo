<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Validator;

use App\Models\User;
use App\Models\Site;
use App\Models\Role;
use App\Helpers\Mailer;
use App\Helpers\Html;
use App\Helpers\Flash;

/**
 * AuthController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AuthController extends BaseController {

    /**
     * Shows the login form.
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handles a login request.
     */
    public function postLogin(Request $request)
    {
        $input = $request->only('username', 'password');

        $validator = Validator::make($input, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        if ($user = User::validateCredentials($input['username'], $input['password']))
        {
            Auth::login($user);
            return redirect('dashboard');
        }
        else
        {
            Flash::error('The email or password your entered is incorrect.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Shows the signup form.
     */
    public function getSignup()
    {
        return view('auth.signup');
    }

    /**
     * Handles a signup request.
     */
    public function postSignup(Request $request)
    {
        $input = $request->only('user');

        // Validate site ID
        if ( ! Site::find($input['user']['site_id']))
        {
            Flash::error('Your site ID is invalid.');
            return redirect()->back()->withInput();
        }

        $validator = Validator::make($input['user'], User::$signupRules);

        // Validate form
        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Create user
        $user = User::create($input['user']);
        $user->attachRoles([Role::CLIENT, Role::LOGIN]);

        Auth::login($user);
        Mailer::sendWelcome($user);

        return redirect('dashboard');
    }

    /**
     * Shows the forgot password form.
     */
    public function getForgotPassword()
    {
        return view('auth.forgot_password');
    }

    /**
     * Handles forgot password request.
     */
    public function postForgotPassword(Request $request)
    {
        $input = $request->only('email');
        $validator = Validator::make($input, ['email' => 'required|email']);

        if ($validator->fails())
        {
            Flash::error($validator);
        }
        else
        {
            if ($user = User::where('email', '=', $input['email'])->first())
            {
                Mailer::sendPasswordRecovery($user);
                // @TODO: change message
                Flash::info('<a href="/reset-password?email=' . $user->email . '&token=' . $user->makePasswordRecoveryToken() . '">Click here to reset your password</a>');
            }

            // Show success message regardless
            // @TODO: uncomment
            //Flash::info('An email with instructions on how to reset your password has been sent.');
        }

        return redirect()->back();
    }

    /**
     * Shows the password reset form.
     */
    public function getResetPassword()
    {
        return view('auth.reset_password');
    }

    /**
     * Handles a password reset request.
     */
    public function postResetPassword(Request $request)
    {
        $input = $request->only('email', 'token', 'password');

        $validator = Validator::make($input, [
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back();
        }

        $user = User::where('email', '=', $input['email'])->first();

        if ($user && $user->checkPasswordRecoveryToken($input['token']))
        {
            $user->password = $input['password'];
            $user->save();
            Flash::success('Your password has been reset successfully.');
            return redirect('login');
        }
        else
        {
            Flash::error('Password reset failed.');
            return redirect()->back();
        }
    }
}
