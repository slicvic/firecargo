<?php

namespace App\Http\Requests;

/**
 * UpdateUserFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UpdateUserFormRequest extends CreateUserFormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['email'] .= ',' . $this->id;
        $rules['password'] = str_replace('required|', '', $rules['password']);

        return $rules;
    }
}
