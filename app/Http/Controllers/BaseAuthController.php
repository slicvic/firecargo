<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use View;
use Request;

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
    protected $user;

    /**
     * Constructor.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
        $this->user = $auth->user();

        $this->middleware('auth');

        View::share('isAdminUser', $this->user->isAdmin());
        View::share('isAgentUser', $this->user->isAgent());
        View::share('isCustomerUser', $this->user->isCustomer());
        View::share('currentUser', $this->user);
        View::share('currentUri', Request::path());
    }
}
