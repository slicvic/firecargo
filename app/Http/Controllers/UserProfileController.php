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
        return view('user_profile.show', ['user' => $this->user]);
    }

    /**
     * Shows the form for updating the user's profile.
     *
     * @return Response
     */
    public function getEdit()
    {
        return view('user_profile.edit', [
            'user' => $this->user
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

        return $this->redirectBackWithSuccess('Your profile has been updated.');
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
     * @param  Request  $request
     * @return Redirector
     */
    public function postPassword(Request $request)
    {
        $input = $request->all();

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|same:new_password'
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
     * Uploads the user's photo.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function postAjaxUploadPhoto(Request $request)
    {
        $input = $request->only('file');

        // Validate input

        $validator = Validator::make($input, [
            'file' => 'required|image|mimes:gif,jpg,jpeg,png|max:' . Upload::MAX_FILE_SIZE
        ]);

        if ($validator->fails())
        {
           return response()->json(implode(' ', $validator->messages()->all(':message')), 400);
        }

        // Save photo

        try
        {
            Upload::saveUserProfilePhoto($input['file'], $this->user->id);

            $this->user->update(['has_photo' => TRUE]);

            return response()->json('Your photo has been uploaded.');
        }
        catch(Exception $e)
        {
            $this->user->update(['has_photo' => FALSE]);

            return response()->json('Upload failed, please try again.', 500);
        }
    }
}
