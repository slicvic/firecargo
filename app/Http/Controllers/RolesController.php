<?php namespace App\Http\Controllers;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Role;
use Flash;

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

        $this->middleware('admin');
    }

    /**
     * Shows a list of roles.
     *
     * @return Response
     */
    public function getIndex()
    {
        $roles = Role::all();

        return view('roles.index', ['roles' => $roles]);
    }
}
