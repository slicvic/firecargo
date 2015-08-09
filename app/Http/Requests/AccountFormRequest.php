<?php namespace App\Http\Requests;

/**
 * AccountFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class AccountFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|alpha_num_spaces',
            'firstname' => 'min:3|alpha_spaces',
            'lastname' => 'min:3|alpha_spaces',
            'email' => 'email',
            'phone' => 'phone',
            'mobile_phone' => 'phone',
            'fax' => 'phone',
            'address1' => '',
            'city' => 'alpha_spaces',
            'state' => 'alpha_spaces',
            'country_id' => ''
        ];
    }
}
