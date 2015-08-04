<?php namespace App\Http\Requests;

/**
 * RegisterUserFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class RegisterUserFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'affiliate_id' => 'required|exists:companies,affiliate_id',
            'firstname' => 'required|min:3|alpha_spaces',
            'lastname' => 'required|min:3|alpha_spaces',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|between:8,20|confirmed',
            'phone' => 'required|min:7|phone',
            'mobile_phone' => 'min:7|phone',
            'address1' => 'required',
            'city' => 'required|alpha_spaces',
            'state' => 'required|alpha_spaces',
            'country_id' => 'required',
            'terms_and_conditions' => 'accepted',
        ];
    }
}
