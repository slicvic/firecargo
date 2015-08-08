<?php namespace App\Http\Requests;

/**
 * ShipperAccountFormRequest
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class ShipperAccountFormRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3|alpha_num_spaces',
            'city' => 'alpha_spaces',
            'state' => 'alpha_spaces'
        ];
    }
}
