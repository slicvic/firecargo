<?php namespace App\Http\Requests;

use Auth;

/**
 * CompanyProfileFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CompanyProfileFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company.name' => 'required|min:3|alpha_num_spaces',
            'company.email' => 'email',
            'company.phone' => 'min:7|phone',
            'company.fax' => 'min:7|phone',
            'address.city' => 'alpha_spaces',
            'address.state' => 'alpha_spaces',
        ];
    }
}
