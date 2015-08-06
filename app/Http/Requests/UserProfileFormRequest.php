<?php namespace App\Http\Requests;

use Auth;

/**
 * UserProfileFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UserProfileFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required|min:3|alpha_spaces',
            'lastname' => 'required|min:3|alpha_spaces',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
        ];
    }
}
