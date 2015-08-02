<?php namespace App\Http\Controllers;

use Validator;
use Auth;
use Hash;
use Exception;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Address;
use App\Exceptions\ValidationException;
use App\Helpers\Upload;
use Flash;

/**
 * CustomerUserProfileController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CustomerUserProfileController extends UserProfileController {

    /**
     * Displays the user's profile.
     *
     * @return Response
     */
    public function getProfile()
    {
        return view('user_profile.customer.show', ['user' => $this->user]);
    }

    /**
     * Shows the form for updating the user's profile.
     *
     * @return Response
     */
    public function getEdit()
    {
        return view('user_profile.customer.edit', [
            'account' => $this->user->account,
            'address' => $this->user->account->address ?: new Address
        ]);
    }

    /**
     * Updates the user's profile.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postProfile(Request $request)
    {
        $input = $request->only('account', 'address');

        $rules = [
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'firstname' => 'required',
            'lastname' => 'required'
        ];

        // Validate input
        $this->validate($input['account'], $rules);

        // Update user
        $this->user->firstname = $input['account']['firstname'];
        $this->user->lastname = $input['account']['lastname'];
        $this->user->email = $input['account']['email'];
        $this->user->save();

        // Update user's account
        $account = $this->user->account;
        $account->phone = $input['account']['phone'];
        $account->mobile_phone = $input['account']['mobile_phone'];
        $account->autoship = isset($input['account']['autoship']);
        $account->save();

        // Update user's account address
        if ($account->address)
        {
            $account->address->update($input['address']);
        }
        else
        {
            $account->address()->save(new Address($input['address']));
        }

        return $this->redirectWithSuccess('user/profile', 'Your profile has been updated.');
    }
}
