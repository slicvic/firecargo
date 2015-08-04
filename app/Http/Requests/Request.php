<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

use App\Session\Flash;

/**
 * Request
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
abstract class Request extends FormRequest {

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
     * The input keys that should not be flashed on redirect.
     *
     * @var array
     */
    protected $dontsFlash = [];

    /**
     * Format the errors from the given Validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        (new Flash)->error($errors);

        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->errorBag));
    }
}
