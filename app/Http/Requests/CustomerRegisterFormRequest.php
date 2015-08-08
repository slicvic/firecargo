<?php namespace App\Http\Requests;

/**
 * CustomerRegisterFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CustomerRegisterFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'registration_code' => 'required|exists:companies,link_code',
            'firstname' => 'required|min:3|alpha_spaces',
            'lastname' => 'required|min:3|alpha_spaces',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|between:8,20|confirmed',
            'phone' => 'required|phone',
            'mobile_phone' => 'phone',
            'address1' => 'required',
            'city' => 'required|alpha_spaces',
            'state' => 'required|alpha_spaces',
            'country_id' => 'required',
            'terms_and_conditions' => 'accepted',
        ];
    }
}
