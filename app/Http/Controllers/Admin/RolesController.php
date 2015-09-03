<?php

namespace App\Http\Controllers\Admin;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Role;

/**
 * RolesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class RolesController extends BaseAdminController {

    /**
     * Constructor.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        parent::__construct($auth);

        $this->middleware('auth.adminOrHigher');
    }

    /**
     * Show a list of roles.
     *
     * @return View
     */
    public function getIndex()
    {
        $roles = Role::all();

        return view('admin.roles.index', ['roles' => $roles]);
    }
}
