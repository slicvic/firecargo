<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;

/**
 * BaseAuthController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
abstract class BaseAuthController extends BaseController {

    /**
     * The auth guard.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The currently logged in user.
     *
     * @var Auth
     */
    protected $authUser;

    /**
     * Constructor.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->authUser = $auth->user();

        $this->middleware('auth');
    }
}
