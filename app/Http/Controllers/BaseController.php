<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

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

        if ($result instanceof \Illuminate\View\View)
        {
            // Render layout
            return $result;
            //return view($this->layout, ['content' => $result]);
        }
        else
        {
            return $result;
        }
    }
}
