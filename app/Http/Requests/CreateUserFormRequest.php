<?php namespace App\Http\Requests;

/**
 * CreateUserFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class CreateUserFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_id' => 'required',
            'role_id' => 'required',
            'email' => 'required|email|unique:users,email',
            'firstname' => 'required|min:3|alpha_spaces',
            'lastname' => 'required|min:3|alpha_spaces',
            'password' => 'required|between:8,20'
        ];
    }
}
