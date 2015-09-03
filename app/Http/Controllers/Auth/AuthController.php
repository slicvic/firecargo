<?php

namespace App\Http\Controllers\Auth;

use Validator;
use Event;
use Auth;
use Illuminate\Http\Request;
use View;

use App\Models\User;
use App\Models\Company;
use Flash;
use App\Events\UserLoggedInEvent;
use App\Services\RegistrarService;
use App\Http\Controllers\BaseController;

/**
 * AuthController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AuthController extends BaseController {

    /**
     * Constructor.
     */
    public function __construct()
    {
        $registrationCode = ( ! empty($_GET['reg'])) ? $_GET['reg'] : NULL;

        $company = ($registrationCode) ? Company::where('corp_code', $registrationCode)->first() : NULL;

        $queryString = ( ! empty($_SERVER['QUERY_STRING'])) ? '?' . $_SERVER['QUERY_STRING'] : '';

        view()->share('company', $company);
        view()->share('queryString', $queryString);
    }

    /**
     * Log the user out of the application.
     *
     * @return RedirectResponse
     */
    public function getLogout()
    {
        Auth::logout();

        return redirect('/');
    }

    /**
     * Show the login form.
     *
     * @return View
     */
    public function getLogin()
    {
        return view('website.login');
    }

    /**
     * Log a user into the application.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function postLogin(Request $request)
    {
        $input = $request->only('email', 'password');

        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];

        $this->validate($input, $rules);

        $user = User::validateCredentials($input['email'], $input['password']);

        if ( ! $user)
        {
            return $this->redirectBackWithError('The email or password you entered is not valid.');
        }

        Event::fire(new UserLoggedInEvent($user));

        return redirect('dashboard');
    }

    /**
     * Show the signup form.
     *
     * @return View
     */
    public function getRegister()
    {
        return view('website.register');
    }

    /**
     * Register a new user.
     *
     * @param  Request  $request
     * @param  RegistrarService  $registrar
     * @return RedirectResponse
     */
    public function postRegister(Request $request, RegistrarService $registrar)
    {
        $input = $request->all();

        $validator = $registrar->validator($input);

        if ($validator->fails())
        {
            return $this->redirectBackWithError($validator);
        }

        $registrar->create($input);

        return redirect('dashboard');
    }

    /**
     * Show the password recovery form.
     *
     * @return View
     */
    public function getForgotPassword()
    {
        return view('website.forgot_password');
    }

    /**
     * Send a password recovery token to the provided email.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function postForgotPassword(Request $request)
    {
        $input = $request->only('email');

        $this->validate($input, ['email' => 'required|email']);

        $user = User::where(['email', $input['email'], 'active' => TRUE])->first();

        if ( ! $user)
        {
            return $this->redirectBackWithError('The email address you entered isn\'t associated with an active account.');
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
     * Show the password reset form.
     *
     * @return View
     */
    public function getResetPassword()
    {
        return view('website.reset_password');
    }

    /**
     * Reset the password of the given user.
     *
     * @param  Request  $request
     * @return RedirectResponse
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

    /**
     * Activate a user account.
     *
     * @param  Request $request
     * @return View|RedirectResponse
     */
    public function getActivateAccount(Request $request)
    {
        $input = $request->only('email', 'activation_code');

        $validator = Validator::make($input, [
            'email'           => 'required|email',
            'activation_code' => 'required'
        ]);

        if ($validator->fails())
        {
            Flash::error($validator);

            return view('website.activate');
        }

        $user = User::where(['email' => $input['email'], 'activation_code' => $input['activation_code']])->first();

        if ( ! $user)
        {
            Flash::error('Account not found.');

            return view('website.activate');
        }

        $user->active = TRUE;
        $user->save();

        Auth::login($user);

        $this->redirectWithSuccess('dashboard', 'Your account was successfully activated.');
    }

    /**
     * Send account activation code to the given email.
     *
     * @param  Request $request
     * @return View|RedirectResponse
     */
    public function getResendActivationCode(Request $request)
    {
        $input = $request->only('email');

        $validator = Validator::make($input, [
            'email' => 'required|email',
        ]);

        if ($validator->fails())
        {
            Flash::error($validator);

            return view('website.activate');
        }

        $user = User::where(['email' => $input['email']])->first();

        if ( ! $user)
        {
            Flash::error('Account not found.');

            return view('website.activate');
        }

        $user->activation_code = User::makeActivationCode();
        $user->save();

        Flash::success('An activation code was sent to your email.');

        return view('website.activate');
    }
}
