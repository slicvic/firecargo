<?php namespace App\Http\Requests;

use Auth;

/**
 * UpdateCompanyProfileFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UpdateCompanyProfileFormRequest extends Request {

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
            'company.phone' => 'phone',
            'company.fax' => 'phone',
            'address.city' => 'alpha_spaces',
            'address.state' => 'alpha_spaces',
        ];
    }
}
