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
     * Shows the form for updating the user's profile.
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
        $input = $request->only('user');

        $rules = User::$signupRules;
        $rules['email'] .= ',' . $this->user->id;
        unset($rules['password']);

        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        $this->user->update($input['user']);

        return redirect()->back();
    }

    /**
     * Shows the form for changing the user's password.
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
            Flash::error($validator);
            return redirect()->back()->withInput();
        }
        else
        {
            if (Hash::check($input['current'], $this->user->password))
            {
                if ($input['new'] != $input['current'])
                {
                    // Update the password only if it differs from the current one
                    $this->user->password = $input['new'];
                    $this->user->save();
                }

                Flash::success('Your password was changed successfully!');
            }
            else
            {
                // Current password doesn't match
                Flash::error('The password you entered does not match your current one.');
            }
        }

        return redirect()->back();
    }
}
