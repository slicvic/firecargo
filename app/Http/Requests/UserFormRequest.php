<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserFormRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

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
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
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
