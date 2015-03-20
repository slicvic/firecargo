<?php namespace App\Http\Controllers;

use Validator;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\User;
use App\Helpers\Flash;

class UsersController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('admin');
    }

    /**
     * Logs out the current user.
     */
    public function getLogout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Displays a list of users.
     */
    public function getIndex(Request $request)
    {
        return $this->getPageView('users.index');
    }

    /**
     * Gets data for jQuery Datatable.
     *
     * @uses    ajax
     * @return  json
     */
    public function getAjaxIndex(Request $request)
    {
        $input = $request->all();

        // Limit and offset
        $limit = isset($input['length']) ? (int) $input['length'] : 10;
        $offset = isset($input['start']) ? (int) $input['start'] : 0;

        // Sort column and direction
        $columns = array(
            'id',
            'company_name',
            'firstname',
            'lastname',
            'email',
            'home_phone',
            'cell_phone'
        );
        $order_by = isset($input['order'][0]) && isset($columns[$input['order'][0]['column']]) ? $columns[$input['order'][0]['column']] : 'id';
        $order = isset($input['order'][0]) ? $input['order'][0]['dir'] : 'desc';
        $search_term = empty($input['search']['value']) ? NULL : $input['search']['value'];

        // Run query
        $results = User::getDatatable($search_term, FALSE, $offset, $limit, $order_by, $order);
        $total = User::getDatatable($search_term, TRUE);

        // Process response
        $response = array();
        $response['recordsFiltered'] = $total;
        $response['data'] = array();

        foreach($results as $user) {
            $response['data'][] = array(
                $user->id,
                $user->company_name,
                $user->firstname,
                $user->lastname,
                $user->email,
                $user->home_phone,
                $user->cell_phone,
                sprintf('<a href="/users/edit/%s" class="btn btn-flat icon"><i class="fa fa-pencil"></i></a>', $user->id)
            );
        }
        return response()->json($response);
    }

    /**
     * Displays the given user's profile.
     *
     * @uses ajax
     */
    public function getView($id)
    {
        $user = User::find($id);

        if ($user) {
            $this->layout = View::make('admin/users/view')
                ->with('user', $user);;
        }
        else {
            Response::json(['success' => FALSE, 'error_message' => 'User not found']);
        }
    }

    /**
     * Shows the form for creating a user.
     */
    public function getCreate()
    {
        return $this->getPageView('users.form', ['user' => new User()]);
    }

    /**
     * Stores a newly created user.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();

        $rules = User::$rules;
        unset($rules['password']);
        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $user = User::create($input['user']);

        if (isset($input['roles']))
        {
            $user->attachRoles($input['roles']);
        }

        return redirect('users');
    }

    /**
     * Shows the form for editing a user.
     */
    public function getEdit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return $this->getPageView('users.form', ['user' => $user]);
    }

    /**
     * Updates the specified user.
     */
    public function postUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();

        $rules = User::$rules;
        $rules['email'] .= ',' . $id;
        unset($rules['password']);
        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $user->update($input['user']);
        $user->attachRoles((isset($input['roles']) ? $input['roles'] : array()));

        return redirect('users');
    }
}
