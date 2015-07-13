<?php namespace App\Http\Controllers;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\Role;
use App\Helpers\Flash;

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

    /**
     * Shows the form for creating a new role.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('roles.edit', ['role' => new Role]);
    }

    /**
     * Creates a new role.
     *
     * @return Redirector
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        // Validate input
        $this->validate($input, Role::$rules);

        // Create role
        Role::create($input);

        return $this->redirectWithSuccess('roles', 'Role created.');
    }

    /**
     * Shows the form for editing a role.
     *
     * @return Response
     */
    public function getEdit($id)
    {
        $role = Role::findOrFail($id);

        return view('roles.edit', ['role' => $role]);
    }

    /**
     * Updates a specific role.
     *
     * @return Redirector
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('name', 'description');

        // Validate input
        $this->validate($input, Role::$rules);

        // Update role
        Role::updateById($id, $input);

        return $this->redirectBackWithSuccess('Role updated.');
    }

    /**
     * Deletes a specific role.
     *
     * @return Redirector
     */
    public function getDelete(Request $request, $id)
    {
        // TODO
        return redirect()->back();
    }
}
