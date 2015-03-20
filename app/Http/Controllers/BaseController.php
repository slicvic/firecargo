<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class BaseController extends Controller {

	use DispatchesCommands, ValidatesRequests;

    protected $layout;

    protected function getPageView($view, array $data = array())
    {
        return view($this->layout, ['content' => view($view, $data)]);
    }
}
