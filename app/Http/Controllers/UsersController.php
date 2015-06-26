<?php namespace App\Http\Controllers;

use Validator;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\User;
use App\Helpers\Flash;
use App\Helpers\Html;

/**
 * UsersController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class UsersController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    /**
     * Shows a list of users.
     */
    public function getIndex(Request $request)
    {
        return view('users.index');
    }

    /**
     * Returns a list of users for a jquery datatable.
     *
     * @uses    ajax
     * @return  json
     */
    public function getAjaxDatatable(Request $request)
    {
        $input = $request->all();

        // Limit/Offset
        $limit = isset($input['length']) ? (int) $input['length'] : 10;
        $offset = isset($input['start']) ? (int) $input['start'] : 0;

        // Sort order
        $columns = [
            'id',
            'company',
            'firstname',
            'lastname',
            'email',
            'phone',
            'cellphone'
        ];
        $orderBy = isset($input['order'][0]) && isset($columns[$input['order'][0]['column']]) ? $columns[$input['order'][0]['column']] : 'id';
        $order = isset($input['order'][0]) ? $input['order'][0]['dir'] : 'desc';

        // Criteria
        $filters['search_term'] = empty($input['search']['value']) ? NULL : $input['search']['value'];
        $filters['site_id'] = ($this->user->isAdmin()) ? NULL : [$this->user->site_id];

        // Retrieve results
        $results = User::getUsersForDatatable($filters, $offset, $limit, $orderBy, $order);

        // Process response
        $response = [];
        $response['recordsFiltered'] = $results['total'];
        $response['data'] = [];

        foreach($results['users'] as $user) {
            $response['data'][] = [
                $user->id,
                $user->site->name,
                $user->business_name,
                $user->firstname,
                $user->lastname,
                $user->email,
                $user->phone,
                $user->cellphone,
                Html::arrayToBadges($user->getRolesAsArray()),
                sprintf('<a href="/accounts/edit/%s" class="btn btn-flat icon"><i class="fa fa-pencil"></i></a>', $user->id)
            ];
        }

        return response()->json($response);
    }

    /**
     * Shows the form for creating a user.
     */
    public function getCreate()
    {
        return view('users.form', ['user' => new User()]);
    }

    /**
     * Creates a new user.
     */
    public function postStore(Request $request)
    {
        $input = $request->only('user', 'roles');
        $rules = [];

        if ( ! empty($input['user']['password']))
        {
            $rules['password'] = 'min:6';
        }

        if ( ! empty($input['user']['email']))
        {
            $rules['email'] = 'email|unique:users,email';
        }

        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        $input['user']['site_id'] = ($this->user->isAdmin()) ? $input['user']['site_id'] : $this->user->site_id;

        $user = User::create($input['user']);

        if (isset($input['roles']))
        {
            $user->attachRoles($input['roles']);
        }

        Flash::success('Record created successfully.');

        return redirect('accounts');
    }

    /**
     * Shows the form for editing a user.
     */
    public function getEdit(Request $request, $id)
    {
        $user = ($this->user->isAdmin()) ? User::findOrFail($id) : User::findOrFailByIdAndCurrentSiteId($id);

        return view('users.form', ['user' => $user]);
    }

    /**
     * Updates a specific user.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->only('user', 'roles');
        $rules = [];

        if ( ! empty($input['user']['password']))
        {
            $rules['password'] = 'min:6';
        }

        if ( ! empty($input['user']['email']))
        {
            $rules['email'] = 'email|unique:users,email,' . $id;
        }

        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails())
        {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        $user = ($this->user->isAdmin()) ? User::findOrFail($id) : User::findOrFailByIdAndCurrentSiteId($id);
        $user->update($input['user']);
        $user->attachRoles(isset($input['roles']) ? $input['roles'] : []);

        Flash::success('Record updated successfully.');

        return redirect('accounts');
    }
}
