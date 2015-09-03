<?php

namespace App\Http\Requests;

use Auth;

/**
 * UpdateCustomerUserProfileFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UpdateCustomerUserProfileFormRequest extends Request {

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
            'home_phone' => 'required|phone',
            'mobile_phone' => 'phone',
            'address1' => 'required',
            'city' => 'required|alpha_spaces',
            'state' => 'required|alpha_spaces',
            'country_id' => 'required'
        ];
    }
}
