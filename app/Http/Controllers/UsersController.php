<?php namespace App\Http\Controllers;

use Validator;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Session;

use App\Models\User;
use App\Models\Role;
use App\Models\Address;
use App\Helpers\Flash;

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
        return view('users.form', ['user' => new User]);
    }

    /**
     * Creates a new user.
     */
    public function postStore(Request $request)
    {
        $input = $this->prepareInput($request);

        // Validate input
        $rules = [
            'email' => 'email|unique:users,email',
            'first_name' => 'required_without:company_name',
            'last_name' => 'required_without:company_name',
            'company_name' => 'required_without:first_name,last_name',
            'password' => 'min:6'
        ];

        $this->validate($input['user'], $rules);

        // Create user
        $user = new User($input['user']);
        $user->company_id = $this->user->isAdmin() ? $input['user']['company_id'] : $this->user->company_id;
        $user->save();

        // Assign roles
        if ($input['role_ids']) {
            $user->roles()->sync($input['role_ids'] );
        }

        // Create address
        $user->address()->save(new Address($input['address']));

        return $this->redirectWithSuccess('accounts', 'Account created.');
    }

    /**
     * Shows the form for editing a user.
     */
    public function getEdit(Request $request, $id)
    {
        $user = ($this->user->isAdmin()) ? User::findOrFail($id) : User::findOrFailByIdAndCurrentUserCompanyId($id);
        return view('users.form', ['user' => $user]);
    }

    /**
     * Updates a specific user.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $this->prepareInput($request);

        // Validate input
        $rules = [
            'email' => 'email|unique:users,email,' . $id,
            'first_name' => 'required_without:company_name',
            'last_name' => 'required_without:company_name',
            'company_name' => 'required_without:first_name,last_name',
            'password' => 'min:6'
        ];

        $this->validate($input['user'], $rules);

        // Update user
        $user = $this->user->isAdmin() ? User::findOrFail($id) : User::findOrFailByIdAndCurrentUserCompanyId($id);
        $user->company_id = $this->user->isAdmin() ? $input['user']['company_id'] : $user->company_id;
        $user->fill($input['user'])->save();

        // Update roles
        $user->roles()->sync($input['role_ids'] ?: []);

        // Update address
        if ($user->address) {
            $user->address->update($input['address']);
        }
        else {
            $user->address()->save(new Address($input['address']));
        }

        return $this->redirectBackWithSuccess('Account updated.');
    }

    /**
     * Retrieves a list of users for a jQuery DataTable.
     *
     * @uses    ajax
     * @return  json
     */
    public function getAjaxDatatable(Request $request)
    {
        $input = $request->all();

        // Get the limit and offset
        $limit = isset($input['length']) ? (int) $input['length'] : 10;
        $offset = isset($input['start']) ? (int) $input['start'] : 0;

        // Get sort column and order
        $sortColumns = [
            'id',
            'company_name',
            'first_name',
            'last_name',
            'email',
            'phone',
            'mobile_phone'
        ];
        $orderBy = isset($input['order'][0]) && isset($sortColumns[$input['order'][0]['column']]) ? $sortColumns[$input['order'][0]['column']] : 'id';
        $order = isset($input['order'][0]) ? $input['order'][0]['dir'] : 'desc';

        // Create search criteria
        $criteria['q'] = empty($input['search']['value']) ? NULL : $input['search']['value'];
        $criteria['company_id'] = $this->user->isAdmin() ? NULL : [$this->user->company_id];

        // Retrieve results
        $results = User::datatableSearch($criteria, $offset, $limit, $orderBy, $order);

        // Process response
        $response = [];
        $response['recordsFiltered'] = $results['total'];
        $response['recordsTotal'] = $results['total'];
        $response['data'] = [];

        foreach($results['users'] as $user) {
            $data = [
                $user->company_name,
                $user->first_name,
                $user->last_name,
                $user->email,
                $user->phone,
                $user->mobile_phone,
                $user->present()->roles(),
                sprintf('<a href="/accounts/edit/%s" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit</a>', $user->id)
            ];

            if ($this->user->isAdmin()) {
                $data = array_merge([$user->id, $user->company->name], $data);
            }
            else {
                $data = array_merge([$user->id], $data);
            }

            $response['data'][] = $data;
        }

        return response()->json($response);
    }

    /**
     * Prepares the input before validation.
     *
     * @param  Request $request
     * @return array
     */
    private function prepareInput(Request $request)
    {
        $input = $request->only('user', 'role_ids', 'address');

        if ( ! $this->user->isAdmin()) {
            // Prohibit setting "admin" role
            if ($input['role_ids'] && in_array(Role::ADMIN, $input['role_ids'])) {
                $input['role_ids'] = array_diff($input['role_ids'], [Role::ADMIN]);
            }
        }

        return $input;
    }
}
