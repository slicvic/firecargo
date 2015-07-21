<?php namespace App\Http\Controllers;

use Validator;
use Auth;
use Session;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use Flash;

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

        $this->middleware('admin');
    }

    /**
     * Shows a list of users.
     *
     * @return Response
     */
    public function getIndex(Request $request)
    {
        $users = User::with('company')->get();

        return view('users.index', ['users' => $users]);
    }

    /**
     * Shows the form for creating a user.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('users.edit', ['user' => new User]);
    }

    /**
     * Creates a new user.
     *
     * @param  Request  $request
     * @return Redirector
     */
    public function postStore(Request $request)
    {
        $input = $this->beforeValidate($request);

        // Validate input
        $rules = [
            'company_id' => 'required',
            'role_id' => 'required',
            'email' => 'required|email|unique:users,email',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required|min:8'
        ];

        $this->validate($input['user'], $rules);

        // Create user
        $user = new User($input['user']);

        if ( ! $user->save())
        {
            return $this->redirectBackWithError('User creation failed, please try again.');
        }

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
        $user = User::find($id);

        if ( ! $user)
        {
            return $this->redirectBackWithError('User not found.');
        }

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Updates a specific user.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Redirector
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $this->beforeValidate($request);

        // Validate input
        $rules = [
            'company_id' => 'required',
            'role_id' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'min:8'
        ];

        $this->validate($input['user'], $rules);

        // Update user
        $user = User::find($id);

        if ( ! $user)
        {
            return $this->redirectBackWithError('User not found.');
        }

        $user->update($input['user']);

        return $this->redirectBackWithSuccess('User updated.');
    }

    /**
     * Prepares the input before validation.
     *
     * @param  Request $request
     * @return array
     */
    private function beforeValidate(Request $request)
    {
        $input = $request->only('user');

        $input['user']['active'] = isset($input['user']['active']);

        return $input;
    }
}
