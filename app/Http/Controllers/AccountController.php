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
     * Logs out the current user.
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
        $dashboard_view = view('account.dashboard', ['user' => Auth::user()]);
        return view('account.layout', ['content' => $dashboard_view]);
    }

    /**
     * Displays the form for updating the profile.
     */
    public function getProfile()
    {
        $profile_view = view('account.profile', ['user' => Auth::user()]);
        return view('account.layout', ['content' => $profile_view]);
    }

    /**
     * Updates the user profile.
     */
    public function postProfile(Request $request)
    {
        $user = Auth::user();
        $input = $request->all();

        $rules = User::$rules;
        $rules['email'] .= ',' . $user->id;
        unset($rules['password']);

        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $user->update($input['user']);

        return redirect()->back();
    }

    /**
     * Displays the form for changing the password.
     */
    public function getPassword()
    {
        $password_view = view('account.password');
        return view('account.layout', ['content' => $password_view]);
    }

    /**
     * Updates the user password.
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
            $user = Auth::user();

            if (Hash::check($input['current'], $user->password) )
            {
                // Update it only if it differs from the current one
                if ($input['new'] != $input['current'])
                {
                    $user->password = $input['new'];
                    $user->save();
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
