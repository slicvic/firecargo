<?php namespace App\Http\Controllers;

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
class UsersController extends BaseAuthController {

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
     * Shows a list of users.
     *
     * @return Response
     */
    public function getIndex(Request $request)
    {
        $users = User::with('company')->get();

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Shows the form for creating a new user.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('admin.users.create', ['user' => new User]);
    }

    /**
     * Creates a new user.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postStore(CreateUserFormRequest $request)
    {
        $input = $this->prepareInput($request);

        User::create($input);

        return $this->redirectWithSuccess('users', 'User created.');
    }

    /**
     * Shows the form for editing a user.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Response
     */
    public function getEdit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Updates a specific user.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function postUpdate(UpdateUserFormRequest $request, $id)
    {
        $input = $this->prepareInput($request);

        User::findOrFail($id)->update($input);

        return $this->redirectBackWithSuccess('User updated.');
    }

    /**
     * Prepares the input before saving to database.
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
