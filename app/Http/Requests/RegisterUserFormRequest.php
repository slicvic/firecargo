<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterUserFormRequest extends Request {

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
		return [
            'af_id' => 'required|exists:companies,affiliate_id',
            'firstname' => 'required|min:3|alpha_spaces',
            'lastname' => 'required|min:3|alpha_spaces',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|min:7|phone',
            'password' => 'required|between:8,20|confirmed',
            'address1' => 'required|min:3',
            'city' => 'required|min:3|alpha_spaces',
            'state' => 'required|min:3|alpha_spaces',
            'country_id' => 'required',
            'terms_and_conditions' => 'accepted',
		];
	}
}
