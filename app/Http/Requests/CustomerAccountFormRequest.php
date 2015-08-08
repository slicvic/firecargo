<?php namespace App\Http\Requests;

/**
 * CustomerAccountFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CustomerAccountFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|alpha_spaces',
            'email' => 'email',
            'phone' => 'phone',
            'mobile_phone' => 'phone',
            'fax' => 'phone',
            'address1' => 'required',
            'city' => 'required|alpha_spaces',
            'state' => 'required|alpha_spaces',
            'country_id' => 'required'
        ];
    }
}
