<?php namespace App\Http\Requests;

class UserFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'company_id' => 'required',
            'role_id' => 'required',
            'email' => 'required|email|unique:users,email',
            'firstname' => 'required|min:3|alpha_spaces',
            'lastname' => 'required|min:3|alpha_spaces',
            'password' => 'required|between:8,20'
        ];

        if ($this->path() != 'user/store')
        {
            $rules['email'] .= ',' . $this->id;
            $rules['password'] = 'between:8,20';
        }

        return $rules;
    }
}
