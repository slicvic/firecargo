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
use App\Http\Requests\CustomerUserProfileFormRequest;

/**
 * UserProfileController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UserProfileController extends BaseAuthController {

    /**
     * Displays the user profile.
     *
     * @return Response
     */
    public function getProfile()
    {
        if ($this->user->isCustomer())
        {
            return view('admin.user_profile.customer.show', ['user' => $this->user]);
        }

        return view('admin.user_profile.show', ['user' => $this->user]);
    }

    /**
     * Shows the form for updating the user profile.
     *
     * @return Response
     */
    public function getEditProfile()
    {
        if ($this->user->isCustomer())
        {
            return view('admin.user_profile.customer.edit', [
                'account' => $this->user->account,
                'address' => $this->user->account->address ?: new Address
            ]);
        }

        return view('admin.user_profile.edit', [
            'user' => $this->user
        ]);
    }

    /**
     * Updates a user profile.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postUpdateProfile(Request $request)
    {
        $input = $request->only('user');

        $rules = [
            'email'     => 'required|email|unique:users,email,' . $this->user->id,
            'firstname' => 'required|min:3|alpha_spaces',
            'lastname'  => 'required|min:3|alpha_spaces'
        ];

        // Validate input
        $this->validate($input['user'], $rules);

        // Update user
        $this->user->update($input['user']);

        return $this->redirectWithSuccess('user/profile', 'Your profile has been updated.');
    }

    /**
     * Updates a customer user profile.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postUpdateCustomerProfile(CustomerUserProfileFormRequest $request)
    {
        $input = $request->all();

        // Update customer
        $user = $this->user;
        $user->firstname = $input['firstname'];
        $user->lastname = $input['lastname'];
        $user->email = $input['email'];
        $user->save();

        // Update customer account
        $account = $this->user->account;
        $account->phone = $input['phone'];
        $account->mobile_phone = $input['mobile_phone'];
        $account->autoship = isset($input['autoship']);
        $account->save();

        // Update customer account address
        $address = $account->address;
        $address->address1 = $input['address1'];
        $address->address2 = $input['address2'];
        $address->city = $input['city'];
        $address->state = $input['state'];
        $address->postal_code = $input['postal_code'];
        $address->country_id = $input['country_id'];
        $address->save();

        return $this->redirectWithSuccess('user/profile', 'Your profile has been updated.');
    }

    /**
     * Shows the form for changing the user password.
     *
     * @return Response
     */
    public function getChangePassword()
    {
        return view('admin.user_profile.change_password');
    }

    /**
     * Updates the user password.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postChangePassword(Request $request)
    {
        $input = $request->all();

        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed'
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
    public function postUploadPhoto(Request $request)
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
}
