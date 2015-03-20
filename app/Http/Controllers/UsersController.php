<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;

use App\Models\User;
use App\Helpers\Flash;

class UsersController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('admin');
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
    public function getAjaxDatatable(Request $request)
    {
        $input = $request->all();

        // Limit and offset
        $limit = isset($input['length']) ? (int) $input['length'] : 10;
        $offset = isset($input['start']) ? (int) $input['start'] : 0;

        // Sort column and direction
        $columns = array(
            'id',
            'company',
            'firstname',
            'lastname',
            'email',
            'home_phone',
            'cell_phone'
        );
        $order_by = isset($input['order'][0]) && isset($columns[$input['order'][0]['column']]) ? $columns[$input['order'][0]['column']] : 'id';
        $order = isset($input['order'][0]) ? $input['order'][0]['dir'] : 'desc';
        $search_value = empty($input['search']['value']) ? NULL : $input['search']['value'];

        // Run query
        $results = User::getDatatableData($search_value, FALSE, $offset, $limit, $order_by, $order);
        $total = User::getDatatableData($search_value, TRUE);

        // Process response
        $response = array();
        $response['recordsFiltered'] = $total;
        $response['data'] = array();

        foreach($results as $record) {
            $response['data'][] = array(
                $record->id,
                $record->company,
                $record->firstname,
                $record->lastname,
                $record->email,
                $record->home_phone,
                $record->cell_phone,
                sprintf('<a href="/users/edit/%s" class="btn btn-default"><i class="fa fa-edit"></i></a>', $record->id)
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
     * Creates a new user.
     *
     * @uses ajax
     */
    public function anyNew()
    {
        if (Request::isMethod('post')) {
            $response = ['success' => FALSE];
            $input = Input::all();
            $validator = Validator::make(
                $input['user'], [
                    'email' => 'email|unique:users,email'
                ]
            );

            if ($validator->fails()) {
                $response['error_message'] = $validator->messages()->first('email');
            }
            else {
                $user = User::create($input['user']);
                if (isset($input['roles'])) {
                    $user->attachRoles($input['roles']);
                }
                $response['success'] = TRUE;
                $response['redirect_to'] = '/admin/users';
            }

            return Response::json($response);
        }
        else {
            $this->layout->content = View::make('admin.users.form')
                ->with('user', new User());
        }
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

        $rules = User::$rules;
        $rules['email'] .= ',' . $id;
        $validator = Validator::make($input = $request->all(), $rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $user->update($input);
        $user->attachRoles((isset($input['roles']) ? $input['roles'] : array()));

        return redirect('users');
    }
}
