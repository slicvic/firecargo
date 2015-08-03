<?php namespace App\Http\Controllers;

use Validator;
use Auth;
use Hash;
use Exception;
use Log;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Address;
use App\Exceptions\ValidationException;
use App\Helpers\Upload;
use App\Http\ToastrJsonResponse;

/**
 * UserProfileController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UserProfileController extends BaseAuthController {

    /**
     * Logs out the user.
     *
     * @return Redirector
     */
    public function getLogout()
    {
        Auth::logout();

        return redirect('/');
    }

    /**
     * Displays the user profile.
     *
     * @return Response
     */
    public function getProfile()
    {
        if ($this->user->isCustomer())
        {
            return view('user_profile.customer.show', ['user' => $this->user]);
        }
        else
        {
            return view('user_profile.show', ['user' => $this->user]);
        }
    }

    /**
     * Shows the form for updating the user profile.
     *
     * @return Response
     */
    public function getEdit()
    {
        if ($this->user->isCustomer())
        {
            return view('user_profile.customer.edit', [
                'account' => $this->user->account,
                'address' => $this->user->account->address ?: new Address
            ]);
        }
        else
        {
            return view('user_profile.edit', [
                'user' => $this->user
            ]);
        }
    }

    /**
     * Updates the user profile.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postProfile(Request $request)
    {
        if ($this->user->isCustomer())
        {
            $this->updateCustomerProfile($request);
        }
        else
        {
            $this->updateProfile($request);
        }

        return $this->redirectWithSuccess('user/profile', 'Your profile has been updated.');
    }

    /**
     * Shows the form for changing the user password.
     *
     * @return Response
     */
    public function getPassword()
    {
        return view('user_profile.password');
    }

    /**
     * Updates the user password.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postPassword(Request $request)
    {
        $input = $request->all();

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ];

        // Validate input
        $this->validate($input, $rules);

        if ( ! Hash::check($input['current_password'], $this->user->password))
        {
            return $this->redirectBackWithError('The password you entered does not match your current one.');
        }

        // Change password
        $this->user->password = $input['new_password'];
        $this->user->save();

        return $this->redirectBackWithSuccess('Your password has been changed.');
    }

    /**
     * Uploads the profile photo.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function postPhoto(Request $request)
    {
        $input = $request->only('file');

        // Validate file

        $validator = Validator::make($input, [
            'file' => 'required|image|mimes:gif,jpg,jpeg,png|max:' . Upload::MAX_FILE_SIZE
        ]);

        if ($validator->fails())
        {
            return ToastrJsonResponse::error($validator, 404);
        }

        // Save photo

        try
        {
            Upload::saveUserProfilePhoto($input['file'], $this->user->id);

            $this->user->update(['has_photo' => TRUE]);

            return ToastrJsonResponse::success('Your photo has been uploaded.');
        }
        catch(Exception $e)
        {
            Log::error($e);

            return ToastrJsonResponse::error('Upload failed, please try again.', 500);
        }
    }

    /**
     * Updates an admin or agent profile.
     *
     * @param  Request  $request
     * @return void
     */
    private function updateProfile(Request $request)
    {
        $input = $request->only('user');

        $rules = [
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'firstname' => 'required',
            'lastname' => 'required'
        ];

        // Validate input
        $this->validate($input['user'], $rules);

        // Update user
        $this->user->update($input['user']);
    }

    /**
     * Updates a customer profile.
     *
     * @param  Request  $request
     * @return void
     */
    private function updateCustomerProfile(Request $request)
    {
        $input = $request->only('account', 'address');

        $rules = [
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'firstname' => 'required',
            'lastname' => 'required'
        ];

        // Validate input
        $this->validate($input['account'], $rules);

        // Update customer
        $this->user->firstname = $input['account']['firstname'];
        $this->user->lastname = $input['account']['lastname'];
        $this->user->email = $input['account']['email'];
        $this->user->save();

        // Update customer account
        $account = $this->user->account;
        $account->phone = $input['account']['phone'];
        $account->mobile_phone = $input['account']['mobile_phone'];
        $account->autoship = isset($input['account']['autoship']);
        $account->save();

        // Update customer account address
        if ($account->address)
        {
            $account->address->update($input['address']);
        }
        else
        {
            $account->address()->save(new Address($input['address']));
        }
    }
}
