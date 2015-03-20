<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\Role;
use App\Helpers\Flash;

class RolesController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('master');
    }

    /**
     * Displays a list of roles.
     */
    public function getIndex()
    {
        $roles = Role::all();
        return $this->getPageView('roles.index', ['roles' => $roles]);
    }

    /**
     * Shows the form for creating a new role.
     */
    public function getCreate()
    {
        return $this->getPageView('roles.form', ['role' => new Role()]);
    }

    /**
     * Stores a newly created role.
     */
    public function postStore(Request $request)
    {
        $validator = Validator::make($input = $request->all(), Role::$rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        Role::create($input);

        return redirect('roles');
    }

    /**
     * Shows the form for editing a role.
     */
    public function getEdit($id)
    {
        $role = Role::findOrFail($id);
        return $this->getPageView('roles.form', ['role' => $role]);
    }

    /**
     * Updates the specified role.
     */
    public function postUpdate(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validator = Validator::make($input = $request->all(), Role::$rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $role->update($input);

        return redirect('roles');
    }
}
