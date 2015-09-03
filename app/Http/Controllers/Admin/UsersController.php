<?php

namespace App\Http\Controllers\Admin;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\CreateUserFormRequest;
use App\Http\Requests\UpdateUserFormRequest;

/**
 * UsersController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UsersController extends BaseAdminController {

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
     * Show a list of users.
     *
     * @return View
     */
    public function getIndex(Request $request)
    {
        $users = User::with('company')->get();

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return View
     */
    public function getCreate()
    {
        return view('admin.users.create', ['user' => new User]);
    }

    /**
     * Create a new user.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function postStore(CreateUserFormRequest $request)
    {
        $input = $this->prepareInput($request);

        User::create($input);

        return $this->redirectWithSuccess('users', 'User created.');
    }

    /**
     * Show the form for editing a user.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return View
     */
    public function getEdit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update a specific user.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return RedirectResponse
     */
    public function postUpdate(UpdateUserFormRequest $request, $id)
    {
        $input = $this->prepareInput($request);

        User::findOrFail($id)->update($input);

        return $this->redirectBackWithSuccess('User updated.');
    }

    /**
     * Prepare the input for prior to database.
     *
     * @param  Request $request
     * @return array
     */
    private function prepareInput(Request $request)
    {
        $input = $request->all();

        $input['active'] = isset($input['active']);

        return $input;
    }
}
