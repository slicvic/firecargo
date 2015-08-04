<?php namespace App\Http\Requests;

class CustomerAccountFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|alpha_spaces',
            'email' => 'email',
            'phone' => 'min:7|phone',
            'mobile_phone' => 'min:7|phone',
            'fax' => 'min:7|phone',
            'address1' => 'required',
            'city' => 'required|alpha_spaces',
            'state' => 'required|alpha_spaces',
            'country_id' => 'required'
        ];

        return $rules;
    }
}
