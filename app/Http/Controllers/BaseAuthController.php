<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

/**
 * BaseAuthController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
abstract class BaseAuthController extends BaseController {

    /**
     * The authentication object.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * The currently logged in user.
     *
     * @var User
     */
    protected $user;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->user = $auth->user();
        $this->middleware('auth');
    }
}
