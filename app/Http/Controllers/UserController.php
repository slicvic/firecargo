<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;

use App\Models\User;
use App\Models\Address;
use App\Helpers\Flash;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * UserProfileController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UserController extends BaseAuthController {

    /**
     * Logs out the user.
     */
    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Displays the user's profile.
     */
    public function getProfile()
    {
        $view = view('user_profile.show', ['user' => $this->user]);
        return view('user_profile.layout', ['content' => $view]);
    }

    /**
     * Shows the form for updating the user's profile.
     */
    public function getEdit()
    {
        $view = view('user_profile.edit', ['user' => $this->user]);
        return view('user_profile.layout', ['content' => $view]);
    }

    /**
     * Updates the user's profile.
     */
    public function postProfile(Request $request)
    {
        $input = $request->only('user', 'address');

        // Validate input
        $rules = User::$rules;
        $rules['email'] .= ',' . $this->user->id;

        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Update user
        $input['user']['autoship_packages'] = isset($input['user']['autoship_packages']);
        $this->user->update($input['user']);

        // Update address
        if ($this->user->address) {
            $this->user->address->update($input['address']);
        }
        else {
            $address = new Address($input['address']);
            $address->user()->associate($this->user);
            $address->save();
        }

        Flash::success('Your profile was updated.');
        return redirect()->back();
    }

    /**
     * Shows the form for changing the user's password.
     */
    public function getPassword()
    {
        $passwordView = view('user_profile.password');
        return view('user_profile.layout', ['content' => $passwordView]);
    }

    /**
     * Updates the user's password.
     */
    public function postPassword(Request $request)
    {
        $input = $request->all();

        // Validate input
        $validator = Validator::make($input, [
            'current' => 'required',
            'new' => 'required'
        ]);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Change password
        if (Hash::check($input['current'], $this->user->password)) {
            $this->user->password = $input['new'];
            $this->user->save();
            Flash::success('Your password was changed successfully.');
        }
        else {
            Flash::error('The password you entered does not match your current one.');
        }

        return redirect()->back();
    }

    /**
     * Uploads the user's photo.
     *
     * @uses    ajax
     * @return  json
     */
    public function postAjaxUploadPhoto(Request $request)
    {
        $input = $request->only('file');

        // Validate input
        $maxKb = 10000; // 10 MB
        $validator = Validator::make($input, [
            'file' => 'required|image|mimes:gif,jpg,jpeg,png|max:' . $maxKb
        ]);

        if ($validator->fails()) {
           return response()->json($validator->messages()->toArray(), 500);
        }

        // Create destination directory
        $destination = public_path() . '/uploads/users/' . $this->user->id . '/images/profile/';
        if ( ! file_exists($destination)) {
            mkdir($destination, 0775, TRUE);
        }

        // Make thumbnails
        $dimensions = [
            'sm' => 48,
            'md' => 200
        ];

        foreach ($dimensions as $filename => $dimension) {
            Image::make($input['file']->getPathName())
                ->orientate()
                ->resize($dimension, $dimension, function($constraint) {
                    //$constraint->aspectRatio();
                    //$constraint->upsize();
                })
                ->save($destination . $filename . '.png');
        }

        unlink($input['file']->getPathName());
        return response()->json([]);
    }
}
