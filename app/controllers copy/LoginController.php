<?php

class LoginController extends BaseController {

    protected $layout = 'website.layouts.default';

    /**
     * Logs out the current user.
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('/');
    }

    /**
     * Login page.
     */
    public function getLogin()
    {
        $this->layout->content = View::make('website.login');
    }

    /**
     * Authenticates a user.
     *
     * @uses ajax
     * @return json
     */
    public function postLogin()
    {
        $input = Input::only('username', 'password');
        $response = ['success' => FALSE];

        if ($input['username'] && $input['password'] && $user = User::auth($input['username'], $input['password'])) {
            // Success
            Auth::login($user);
            $response['success'] = TRUE;
            $response['redirect_to'] = ($user->isAdmin() ? 'admin/dashboard' : 'user/dashboard');
        }
        else {
            // Failure
            $response['error_message'] = trans('messages.login_fail');
        }

        return Response::json($response);
    }
}
