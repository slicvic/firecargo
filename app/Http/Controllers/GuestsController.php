<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Validator;

use App\Models\User;
use App\Helpers\Mailer;
use App\Helpers\Html;
use App\Helpers\Flash;

class GuestsController extends BaseController {
    protected $layout = 'layouts.guest';

    /**
     * Shows the login form.
     */
    public function anyLogin(Request $request)
    {
        if ( ! $request->isMethod('post'))
        {
            return $this->getPageView('guests.login');
        }
        else
        {
            $input = $request->only('username', 'password');

            if ($input['username'] && $input['password'] && $user = User::validateCredentials($input['username'], $input['password']))
            {
                Auth::login($user);
                return redirect('dashboard');
            }
            else
            {
                Flash::error(trans('messages.login_fail'));
                return redirect()->back()->withInput();
            }
        }
    }

    /**
     * Shows the signup form.
     */
    public function anySignup(Request $request)
    {
        if ( ! $request->isMethod('post'))
        {
            return $this->getPageView('guests.signup');
        }
        else
        {
            $input = $request->all();

            $validator = Validator::make($input['user'], User::$rules);

            if ($validator->fails())
            {
                Flash::error($validator->messages());
                return redirect()->back()->withInput();
            }
            else
            {
                // Create user
                $user = User::create($input['user']);
                $user->attachRoles([\App\Models\Role::MEMBER, \App\Models\Role::LOGIN]);

                // Log 'em in
                Auth::login($user);

                // Send welcome email
                Mailer::sendWelcome($user);

                // Redirect to dashboard
                return redirect('dashboard');
            }
        }
    }

    /**
     * Shows the password reset form.
     */
    public function anyResetPassword(Request $request)
    {
        if ( ! $request->isMethod('post'))
        {
            return $this->getPageView('guests.reset_password');
        }
        else
        {
            $input = $request->only('email', 'token', 'password');

            $validator = Validator::make($input, [
                'email' => 'required|email',
                'token' => 'required',
                'password' => 'required'
            ]);

            if ($validator->fails())
            {
                Flash::error($validator->messages());
                return redirect()->back();
            }
            else
            {
                $user = User::where('email', '=', $input['email'])->first();

                if ($user && $user->checkPasswordRecoveryToken($input['token']))
                {
                    $user->password = $input['password'];
                    $user->save();
                    Flash::success(trans('messages.password_reset_ok'));
                }
                else
                {
                    Flash::error(trans('messages.password_reset_fail'));
                }
            }

            return redirect()->back();
        }

    }

    /**
     * Shows the forgot password page.
     */
    public function anyForgotPassword(Request $request)
    {
        if ( ! $request->isMethod('post'))
        {
            return $this->getPageView('guests.forgot_password');
        }
        else
        {
            $input = $request->only('email');

            $validator = Validator::make($input, ['email' => 'required|email']);

            if ($validator->fails())
            {
                Flash::error(trans('messages.password_reset_fail'));
            }
            else
            {
                if ($user = User::where('email', '=', $input['email'])->first())
                {
                    Mailer::sendPasswordRecovery($user);
                    Flash::info(trans('messages.password_reset_ok') . '<br><a href="/reset-password?email=' . $user->email . '&token=' . $user->generatePasswordRecoveryToken() . '">Click here to reset your password</a>');
                }
                else
                {
                    Flash::error(trans('messages.password_reset_fail'));
                }
            }

            return redirect()->back();
        }
    }
}
