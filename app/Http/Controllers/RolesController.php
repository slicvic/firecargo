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

    /**
     * Shows the form for creating a new role.
     *
     * @return Response
     */
    public function getCreate()
    {
        return $this->redirectBackWithError('Action disabled.');
    }

    /**
     * Creates a new role.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postStore(Request $request)
    {
        return $this->redirectBackWithError('Action disabled.');
    }

    /**
     * Shows the form for editing a role.
     *
     * @param  int  $id
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
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('name', 'description');

        // Validate input
        $this->validate($input, Role::$rules);

        // Update role
        Role::findOrFail($id)->update($input);

        return $this->redirectBackWithSuccess('Role updated.');
    }

    /**
     * Deletes a specific role.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function getDelete(Request $request, $id)
    {
        return $this->redirectBackWithError('Action disabled.');
    }
}
