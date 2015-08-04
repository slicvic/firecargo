<?php namespace App\Http\Requests;

use Auth;

class CustomerUserProfileFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'firstname' => 'required|min:3|alpha_spaces',
            'lastname' => 'required|min:3|alpha_spaces',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'phone' => 'required|min:7|phone',
            'mobile_phone' => 'min:7|phone',
            'address1' => 'required',
            'city' => 'required|alpha_spaces',
            'state' => 'required|alpha_spaces',
            'country_id' => 'required'
        ];

        return $rules;
    }
}
