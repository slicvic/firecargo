<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Auth\Guard;
use View;
use Request as RequestFacade;
use Auth;

use App\Http\Controllers\BaseController;

/**
 * BaseAdminController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
abstract class BaseAdminController extends BaseController {

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
        $this->middleware('auth');

        if ($auth->check())
        {
            $this->auth = $auth;
            $this->user = $auth->user();
            $this->initViewGlobals();
        }
    }

    /**
     * Initialize global view variables.
     *
     * @return void
     */
    private function initViewGlobals()
    {
        view()->share('isAdminUser', $this->user->isAdmin());
        view()->share('isAgentUser', $this->user->isAgent());
        view()->share('isCustomerUser', $this->user->isCustomer());
        view()->share('currentUser', $this->user);
        view()->share('currentUri', RequestFacade::path());
    }
}
