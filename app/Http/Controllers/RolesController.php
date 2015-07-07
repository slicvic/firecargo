<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Role;
use App\Helpers\Flash;

/**
 * RolesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class RolesController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('admin');
    }

    /**
     * Shows a list of roles.
     */
    public function getIndex()
    {
        $roles = Role::all();
        return view('roles.index', ['roles' => $roles]);
    }

    /**
     * Shows the form for creating a new role.
     */
    public function getCreate()
    {
        return view('roles.form', ['role' => new Role()]);
    }

    /**
     * Creates a new role.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        // Validate input
        $validator = Validator::make($input, Role::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Create role
        Role::create($input);

        Flash::success('Role created.');
        return redirect('roles');
    }

    /**
     * Shows the form for editing a role.
     */
    public function getEdit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.form', ['role' => $role]);
    }

    /**
     * Updates a specific role.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();

        // Validate input
        $validator = Validator::make($input, Role::$rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Update role
        $role = Role::findOrFail($id);
        $role->update($input);

        Flash::success('Role updated.');
        return redirect()->back();
    }

    /**
     * Deletes a specific role.
     */
    public function getDelete(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back();
    }
}
