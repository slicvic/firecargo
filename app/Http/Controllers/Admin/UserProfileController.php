<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Auth;
use Hash;
use Exception;
use Log;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Address;
use App\Helpers\Upload;
use App\Http\Requests\UpdateUserProfileFormRequest;
use App\Http\Requests\UpdateCustomerUserProfileFormRequest;

/**
 * UserProfileController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UserProfileController extends BaseAdminController {

    /**
     * Show the user profile.
     *
     * @return View
     */
    public function getProfile()
    {
        if ($this->user->isCustomer())
        {
            return view('admin.user_profile.customers.show');
        }

        return view('admin.user_profile.admins.show');
    }

    /**
     * Show the form for updating the user profile.
     *
     * @return View
     */
    public function getEditProfile()
    {
        if ($this->user->isCustomer())
        {
            $account = $this->user->account;

            return view('admin.user_profile.customers.edit', [
                'account' => $account,
                'address' => $account->shippingAddress ?: new Address
            ]);
        }

        return view('admin.user_profile.admins.edit');
    }

    /**
     * Update the user profile.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function postProfile(UpdateUserProfileFormRequest $request)
    {
        $input = $request->all();

        $user = $this->user;
        $user->firstname = $input['firstname'];
        $user->lastname = $input['lastname'];
        $user->email = $input['email'];
        $user->save();

        return $this->redirectWithSuccess('user/profile', 'Your profile has been updated.');
    }

    /**
     * Update the user profile for a customer.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function postCustomerProfile(UpdateCustomerUserProfileFormRequest $request)
    {
        $input = $request->all();

        // Update user
        $user = $this->user;
        $user->firstname = $input['firstname'];
        $user->lastname = $input['lastname'];
        $user->email = $input['email'];
        $user->save();

        // Update account
        $account = $user->account;
        $account->home_phone = $input['home_phone'];
        $account->mobile_phone = $input['mobile_phone'];
        $account->autoship = isset($input['autoship']);

        // Update account address
        $address = $account->shippingAddress ?: new Address;
        $address->address1 = $input['address1'];
        $address->address2 = $input['address2'];
        $address->city = $input['city'];
        $address->state = $input['state'];
        $address->postal_code = $input['postal_code'];
        $address->country_id = $input['country_id'];
        $address->save();

        $account->shippingAddress()
            ->associate($address)
            ->save();

        return $this->redirectWithSuccess('user/profile', 'Your profile has been updated.');
    }

    /**
     * Show the form for changing the password.
     *
     * @return View
     */
    public function getChangePassword()
    {
        return view('admin.user_profile.password');
    }

    /**
     * Update the password.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function postChangePassword(Request $request)
    {
        $input = $request->all();

        $this->validate($input, [
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed'
        ]);

        if ( ! Hash::check($input['current_password'], $this->user->password))
        {
            return $this->redirectBackWithError('The password you entered does not match your current one.');
        }

        $this->user->password = $input['new_password'];
        $this->user->save();

        return $this->redirectBackWithSuccess('Your password has been changed.');
    }

    /**
     * Upload the profile photo.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function postUploadPhoto(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'file' => 'required|image|mimes:gif,jpg,jpeg,png|max:' . Upload::MAX_FILE_SIZE
        ]);

        if ($validator->fails())
        {
            return response()->jsonError($validator, 404);
        }

        try
        {
            Upload::saveUserProfilePhoto($input['file'], $this->user->id);

            $this->user->update(['has_photo' => TRUE]);

            return response()->jsonSuccess('Your photo has been uploaded.');
        }
        catch(Exception $e)
        {
            Log::error($e);

            return response()->jsonError('Upload failed, please try again.', 500);
        }
    }
}
