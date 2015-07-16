<?php namespace App\Http\Controllers;

use Validator;
use Auth;
use Hash;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use Intervention\Image\ImageManagerStatic as Image;

use App\Models\User;
use App\Models\Address;
use Flash;


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
     * Displays the user's profile.
     *
     * @return Response
     */
    public function getProfile()
    {
        return view('user_profile.show', ['user' => $this->authUser]);
    }

    /**
     * Shows the form for updating the user's profile.
     *
     * @return Response
     */
    public function getEdit()
    {
        return view('user_profile.edit', [
            'user' => $this->authUser,
            'address' => $this->authUser->address ?: new Address
        ]);
    }

    /**
     * Updates the user's profile.
     *
     * @return Redirector
     */
    public function postProfile(Request $request)
    {
        $input = $request->only('user', 'address');

        // Validate input
        $rules = [
            'email' => 'required|email|unique:users,email,' . $this->authUser->id,
            'full_name' => 'required'
        ];

        $this->validate($input['user'], $rules);

        // Update user
        $input['user']['autoship_setting'] = isset($input['user']['autoship_setting']);
        $this->authUser->update($input['user']);

        // Update address
        if ($this->authUser->address)
        {
            $this->authUser->address->update($input['address']);
        }
        else
        {
            $this->authUser->address()->save(new Address($input['address']));
        }

        return $this->redirectBackWithSuccess('Your profile was updated.');
    }

    /**
     * Shows the form for changing the user's password.
     *
     * @return Response
     */
    public function getPassword()
    {
        return view('user_profile.password');
    }

    /**
     * Updates the user's password.
     *
     * @return Redirector
     */
    public function postPassword(Request $request)
    {
        $input = $request->all();

        // Validate input
        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ];

        $this->validate($input, $rules);

        // Change password
        if ( ! Hash::check($input['current_password'], $this->authUser->password))
        {
            return $this->redirectBackWithError('The password you entered does not match your current one.');
        }

        $this->authUser->password = $input['new_password'];
        $this->authUser->save();

        return $this->redirectBackWithSuccess('Your password was changed successfully.');
    }

    /**
     * Uploads the user's photo.
     *
     * @return JsonResponse
     */
    public function postAjaxUploadPhoto(Request $request)
    {
        $input = $request->only('file');
        $maxKb = 10000;

        // Validate input
        $validator = Validator::make($input, [
            'file' => 'required|image|mimes:gif,jpg,jpeg,png|max:' . $maxKb
        ]);

        if ($validator->fails())
        {
           return response()->json(Flash::view($validator), 500);
        }

        // Create destination directory
        $destination = public_path() . '/uploads/users/' . $this->authUser->id . '/images/profile/';

        if ( ! file_exists($destination))
        {
            mkdir($destination, 0775, TRUE);
        }

        // Make thumbnails
        $dimensions = [
            'sm' => 48,
            'md' => 200
        ];

        foreach ($dimensions as $filename => $dimension)
        {
            Image::make($input['file']->getPathName())
                ->orientate()
                ->resize($dimension, $dimension)
                ->save($destination . $filename . '.png');
        }

        // Remove temp file
        unlink($input['file']->getPathName());

        return response()->json([]);
    }
}
