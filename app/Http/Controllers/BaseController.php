<?php

namespace App\Http\Controllers;

use Validator;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Exceptions\ValidationException;
use Flash;

/**
 * BaseController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
abstract class BaseController extends Controller {

	use DispatchesCommands, ValidatesRequests;

    protected $layout;

    /**
     * Execute an action on the controller.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $response = call_user_func_array(array($this, $method), $parameters);

        return $response;
    }

    /**
     * Validate the given input with the given rules.
     *
     * @param  array  $input
     * @param  array  $rules
     * @return void
     * @throws ValidationException
     */
    protected function validate(array $input, array $rules)
    {
        $validator = Validator::make($input, $rules);

        if ($validator->fails())
        {
            throw new ValidationException($validator->messages());
        }
    }

    /**
     * Redirect to the given path with the given success message.
     *
     * @param  string  $path
     * @param  string  $message
     * @return Redirector
     */
    protected function redirectWithSuccess($path, $message)
    {
        Flash::success($message);

        return redirect($path);
    }

    /**
     * Redirect to the given path with the given error message.
     *
     * @param  string  $path
     * @param  string  $message
     * @return Redirector
     */
    protected function redirectWithError($path, $message)
    {
        Flash::error($message);

        return redirect($path);
    }

    /**
     * Redirect back with the given success message.
     *
     * @param  string  $message
     * @return Redirector
     */
    protected function redirectBackWithSuccess($message)
    {
        Flash::success($message);

        return redirect()->back();
    }

    /**
     * Redirect back with the given error message.
     *
     * @param  string  $message
     * @return Redirector
     */
    protected function redirectBackWithError($message)
    {
        Flash::error($message);

        return redirect()->back()->withInput();
    }
}
