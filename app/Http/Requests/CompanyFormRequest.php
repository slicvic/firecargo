<?php namespace App\Http\Requests;

/**
 * CompanyFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CompanyFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|alpha_num_spaces',
            'firstname' => 'required|min:3|alpha_spaces',
            'lastname' => 'required|min:3|alpha_spaces',
            'email' => 'required|email',
            'phone' => 'required|phone'
        ];
    }
}
