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

        // Validate input
        $rules = [];

        if ( ! empty($input['user']['password'])) {
            $rules['password'] = 'min:6';
        }

        if ( ! empty($input['user']['email'])) {
            $rules['email'] = 'email|unique:users,email';
        }

        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        $input['user']['site_id'] = ($this->user->isAdmin()) ? $input['user']['site_id'] : $this->user->site_id;

        // Create user
        $user = User::create($input['user']);

        // Assign user roles
        if (isset($input['roles'])) {
            $user->attachRoles($input['roles']);
        }

        // Process response
        Flash::success('New account created.');
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

        // Validate input
        $rules = [];

        if ( ! empty($input['user']['password'])) {
            $rules['password'] = 'min:6';
        }

        if ( ! empty($input['user']['email'])) {
            $rules['email'] = 'email|unique:users,email,' . $id;
        }

        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails()) {
            Flash::error($validator);
            return redirect()->back()->withInput();
        }

        // Update user
        $user = ($this->user->isAdmin()) ? User::findOrFail($id) : User::findOrFailByIdAndCurrentSiteId($id);
        $user->update($input['user']);
        $user->attachRoles(isset($input['roles']) ? $input['roles'] : []);

        // Process response
        Flash::success('Account updated.');
        return redirect()->back();
    }

    /**
     * Returns a list of users for a jQuery DataTable.
     *
     * @uses    ajax
     * @return  json
     */
    public function getAjaxDatatable(Request $request)
    {
        $input = $request->all();

        // Obtain Limit / Offset
        $limit = isset($input['length']) ? (int) $input['length'] : 10;
        $offset = isset($input['start']) ? (int) $input['start'] : 0;

        // Obtain order
        $validSortColumns = [
            'id',
            'company',
            'first_name',
            'last_name',
            'email',
            'phone',
            'mobile_phone'
        ];
        $orderBy = isset($input['order'][0]) && isset($validSortColumns[$input['order'][0]['column']]) ? $validSortColumns[$input['order'][0]['column']] : 'id';
        $order = isset($input['order'][0]) ? $input['order'][0]['dir'] : 'desc';

        // Search criteria
        $filters['search_term'] = empty($input['search']['value']) ? NULL : $input['search']['value'];
        $filters['site_id'] = ($this->user->isAdmin()) ? NULL : [$this->user->site_id];

        // Retrieve results
        $results = User::getUsersForDatatable($filters, $offset, $limit, $orderBy, $order);

        // Process response
        $response = [];
        $response['recordsFiltered'] = $results['total'];
        $response['recordsTotal'] = $results['total'];
        $response['data'] = [];

        foreach($results['users'] as $user) {
            $response['data'][] = [
                $user->id,
                $user->site->name,
                $user->business_name,
                $user->first_name,
                $user->last_name,
                $user->email,
                $user->phone,
                $user->mobile_phone,
                Html::arrayToTags($user->present()->rolesAsArray()),
                sprintf('<a href="/accounts/edit/%s" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit</a>', $user->id)
            ];
        }

        return response()->json($response);
    }
}
