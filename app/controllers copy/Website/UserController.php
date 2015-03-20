<?php

class WebsiteUserController extends BaseController {

    protected $layout = 'website.layouts.default';

    public function __construct()
    {
        $this->beforeFilter('auth', ['except' => ['anySignup', 'anyResetPassword', 'postForgotPassword']]);
    }

    /**
     * Dashboard page.
     */
    public function getDashboard()
    {
        $packages = Auth::user()->packages;

        $view = View::make('website.user.packages')
            ->with('packages', $packages);

        $this->layout->content = $view;
    }

    /**
     * Profile page.
     */
    public function getProfile()
    {
        $view = View::make('website.user.edit_profile.layout')
            ->with('user', Auth::user());

        $this->layout->content = $view;
    }

    /**
     * Updates the logged in user's profile.
     *
     * @uses ajax
     * @return json
     */
    public function postUpdateProfile()
    {
        Auth::user()->update(Input::get('user'));
        $response['success'] = TRUE;
        $response['message'] = trans('messages.update_ok');
        return Response::json($response);
    }

    /**
     * Updates the logged in user's email.
     *
     * @uses ajax
     * @return json
     */
    public function postChangeEmail()
    {
        $input = Input::all();
        $response = ['success' => FALSE];

        $validator = Validator::make(
            $input, [
                'email' => 'required|email',
                'current_password' => 'required'
            ]
        );

        if ($validator->fails()) {
            $response['error_message'] = trans('messages.validation_fail');
        }
        else {
            $user = Auth::user();

            if ( ! Hash::check($input['current_password'], $user->password) ) {
                // Current password doesnt't match
                $response['error_message'] = trans('messages.invalid_current_password');
            }
            elseif (User::where('email', $input['email'])->where('id', '<>', $user->id)->first()) {
                // Email is taken
                $response['error_message'] = trans('messages.email_taken');
            }
            else {
                $user->email = $input['email'];
                $user->save();
                $response['success'] = TRUE;
                $response['message'] = trans('messages.change_email_ok');
            }
        }

        return Response::json($response);
    }

    /**
     * Updates the logged in user's password.
     *
     * @uses ajax
     * @return json
     */
    public function postChangePassword()
    {
        $input = Input::all();
        $response = ['success' => FALSE];

        $validator = Validator::make(
            $input, [
                'current_password' => 'required',
                'new_password' => 'required'
            ]
        );

        if ($validator->fails()) {
            $response['error_message'] = trans('messages.validation_fail');
        }
        else {
            $user = Auth::user();

            if (Hash::check($input['current_password'], $user->password) ) {
                if ($input['new_password'] != $input['current_password']) {
                    // Update it only if it differs from current one
                    $user->password = $input['new_password'];
                    $user->save();
                }
                $response['success'] = TRUE;
                $response['message'] = trans('messages.password_reset_ok');
            }
            else {
                // Current password doesnt't match
                $response['error_message'] = trans('messages.invalid_current_password');
            }
        }

        return Response::json($response);
    }

    /**
     * Displays signup page and handles signups.
     */
    public function anySignup()
    {
        if (Request::isMethod('post')) {
            $input = Input::all();
            $response = ['success' => FALSE];

            $validator = Validator::make(
                $input['user'], [
                    'email' => 'required|email',
                    'password' => 'required',
                    'firstname' => 'required',
                    'lastname' => 'required'
                ]
            );

            if ($validator->fails()) {
                $response['error_message'] = trans('messages.validation_fail');
            }
            elseif (User::where('email', $input['user']['email'])->first()) {
                $response['error_message'] = trans('messages.email_taken');
            }
            else {
                // Create user
                $user = User::create($input['user']);
                $user->attachRoles([Role::MEMBER, Role::LOGIN]);

                // Log 'em in
                Auth::login($user);

                // Send welcome email
                Mailer::sendWelcome($user);

                $response['success'] = TRUE;
                $response['redirect_to'] = 'user/dashboard';
            }

            return Response::json($response);
        }

        $this->layout->content = View::make('website.signup');
    }

    /**
     * Displays password reset page and handles password reset.
     */
    public function anyResetPassword()
    {
        if (Request::isMethod('post')) {
            $input = Input::all();
            $response = ['success' => FALSE];

            $validator = Validator::make(
                $input, [
                    'email' => 'required|email',
                    'token' => 'required',
                    'password' => 'required'
                ]
            );

            if ($validator->fails()) {
                $response['error_message'] = trans('messages.password_reset_fail');
            }
            else {
                $user = User::where('email', '=', $input['email'])->first();

                if ($user && $user->checkPasswordRecoveryToken($input['token'])) {
                    $user->password = $input['password'];
                    $user->save();
                    $response['success'] = TRUE;
                    $response['message'] = trans('messages.password_reset_ok');
                }
                else {
                    $response['error_message'] = trans('messages.password_reset_fail');
                }
            }

            return Response::json($response);
        }

        $this->layout->content = View::make('website.reset_password')
            ->with('input', Input::only(['email', 'token']));
    }

    /**
     * Processes forgot password form and sends recovery email.
     *
     * @uses ajax
     * @return json
     */
    public function postForgotPassword()
    {
        $input = Input::all();
        $response = ['success' => FALSE];

        $validator = Validator::make(
            $input, [
                'email' => 'required|email'
            ]
        );

        if ($validator->fails()) {
            $response['error_message'] = trans('messages.invalid_email');
        }
        else {
            if ($user = User::where('email', '=', $input['email'])->first()) {
                // User found, send password reset instructions
                Mailer::sendPasswordRecovery($user);
                $response['success'] = TRUE;
                $response['message'] = trans('messages.password_recovery_ok');
                // TODO: remove this line
                $response['message'] .= '<br><a href="/reset-password?email=' . $user->email . '&token=' . $user->generatePasswordRecoveryToken() . '">Click here to reset your password</a>';
            }
            else {
                // User not found
                $response['error_message'] = trans('messages.password_recovery_fail');
            }
        }

        return Response::json($response);
    }
}
