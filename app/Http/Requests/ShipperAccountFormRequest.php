<?php namespace App\Http\Requests;

class ShipperAccountFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|alpha_spaces',
            'city' => 'alpha_spaces',
            'state' => 'alpha_spaces'
        ];

        return $rules;
    }
}
