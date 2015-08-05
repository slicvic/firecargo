<?php namespace App\Http\Controllers;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Role;

/**
 * RolesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class RolesController extends BaseAuthController {

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
     * Shows a list of roles.
     *
     * @return Response
     */
    public function getIndex()
    {
        $roles = Role::all();

        return view('admin.roles.index', ['roles' => $roles]);
    }
}
