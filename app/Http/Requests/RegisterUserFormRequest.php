<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterUserFormRequest extends Request {

	/**
     * The input keys that should not be flashed on redirect.
     *
     * @var array
     */
    protected $dontsFlash = [];

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
            'referer_id' => 'required|exists:companies',
            'firstname' => 'required|min:3',
            'lastname' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|min:7',
            'password' => 'required|between:8,20|confirmed',
            'address1' => 'required|min:3',
            'city' => 'required|min:3',
            'state' => 'required|min:3',
            'country_id' => 'required',
            'terms_and_conditions' => 'accepted',
		];
	}
}
