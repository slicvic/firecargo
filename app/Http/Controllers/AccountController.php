<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;

use App\Models\User;
use App\Helpers\Flash;

class AccountController extends BaseAuthController {

    /**
     * Logs out the user.
     */
    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

   /**
     * Displays account dashboard.
     */
    public function getDashboard()
    {
        $dashboardView = view('account.dashboard', ['user' => $this->user]);
        return view('account.layout', ['content' => $dashboardView]);
    }

    /**
     * Displays the form for updating the user's profile.
     */
    public function getProfile()
    {
        $profileView = view('account.profile', ['user' => $this->user]);
        return view('account.layout', ['content' => $profileView]);
    }

    /**
     * Updates the user's profile.
     */
    public function postProfile(Request $request)
    {
        $input = $request->all();

        $rules = User::$rules;
        $rules['email'] .= ',' . $this->user->id;
        unset($rules['password']);

        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $this->user->update($input['user']);

        return redirect()->back();
    }

    /**
     * Displays the form for changing the user's password.
     */
    public function getPassword()
    {
        $passwordView = view('account.password');
        return view('account.layout', ['content' => $passwordView]);
    }

    /**
     * Updates the user's password.
     */
    public function postPassword(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'current' => 'required',
            'new' => 'required'
        ]);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }
        else
        {
            if (Hash::check($input['current'], $this->user->password) )
            {
                // Update it only if it differs from the current one
                if ($input['new'] != $input['current'])
                {
                    $this->user->password = $input['new'];
                    $this->user->save();
                }
                Flash::success(trans('messages.password_reset_ok'));
            }
            else
            {
                // Current password doesnt't match
                Flash::error(trans('messages.invalid_current_password'));
            }
        }

        return redirect()->back();
    }
}
