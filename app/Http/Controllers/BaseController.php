<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;

use App\Exceptions\ValidationException;
use App\Helpers\Flash;

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
        $result = call_user_func_array(array($this, $method), $parameters);
        return $result;
    }

    /**
     * Validates the given input with the given rules.
     *
     * @param  array  $input
     * @param  array  $rules
     * @return void
     * @throws ValidationException
     */
    public function validate(array $input, array $rules)
    {
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator->messages());
        }
    }

    /**
     * Redirects to the given path with the given success message.
     *
     * @param  string $path
     * @param  string $message
     * @return redirect()
     */
    public function redirectWithSuccess($path, $message)
    {
        return redirect($path)->with(Flash::SUCCESS, $message);
    }

    /**
     * Redirects to the given path with the given error message.
     *
     * @param  string $path
     * @param  string $message
     * @return redirect()
     */
    public function redirectWithError($path, $message)
    {
        return redirect($path)->with(Flash::ERROR, $message);
    }

    /**
     * Redirects back with the given success message.
     *
     * @param  string $message
     * @return redirect()
     */
    public function redirectBackWithSuccess($message)
    {
        return redirect()->back()->with(Flash::SUCCESS, $message);
    }

    /**
     * Redirects back with the given error message.
     *
     * @param  string $message
     * @return redirect()
     */
    public function redirectBackWithError($message)
    {
        return redirect()->back()->with(Flash::ERROR, $message);
    }
}
