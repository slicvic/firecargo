<?php namespace App\Http\Controllers;

use Validator;
use Auth;
use Session;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\Address;
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

        $this->middleware('agent');
    }

    /**
     * Shows a list of users.
     *
     * @return Response
     */
    public function getIndex(Request $request)
    {
        return view('users.index');
    }

    /**
     * Shows the form for creating a user.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('users.edit', ['user' => new User, 'address' => new Address]);
    }

    /**
     * Creates a new user.
     *
     * @return Redirector
     */
    public function postStore(Request $request)
    {
        $input = $this->prepareInput($request);

        // Validate input
        $rules = [
            'role_id' => 'required',
            'email' => 'email|unique:users,email',
            'full_name' => 'required_without:company_name',
            'company_name' => 'required_without:full_name',
            'password' => 'min:8'
        ];

        $this->validate($input['user'], $rules);

        // Create user
        $user = new User($input['user']);

        if ( ! $user->save())
        {
            return $this->redirectBackWithError('Account creation failed, please try again.');
        }

        // Create address
        $user->address()->save(new Address($input['address']));

        return $this->redirectWithSuccess('accounts', 'Account created.');
    }

    /**
     * Shows the form for editing a user.
     *
     * @return Response
     */
    public function getEdit(Request $request, $id)
    {
        $user = ($this->authUser->isAdmin()) ? User::findOrFail($id) : User::findOrFailByIdAndCurrentUserCompanyId($id);

        return view('users.edit', [
            'user' => $user,
            'address' => $user->address ?: new Address
        ]);
    }

    /**
     * Updates a specific user.
     *
     * @return Redirector
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $this->prepareInput($request);

        // Validate input
        $rules = [
            'role_id' => 'required',
            'email' => 'email|unique:users,email,' . $id,
            'full_name' => 'required_without:company_name',
            'company_name' => 'required_without:full_name',
            'password' => 'min:6'
        ];

        $this->validate($input['user'], $rules);

        // Update user

        $user = $this->authUser->isAdmin() ? User::findOrFail($id) : User::findOrFailByIdAndCurrentUserCompanyId($id);
        $user->fill($input['user']);
        $user->save();

        // Update address
        if ($user->address)
        {
            $user->address->update($input['address']);
        }
        else
        {
            $user->address()->save(new Address($input['address']));
        }

        return $this->redirectBackWithSuccess('Account updated.');
    }

    /**
     * Retrieves a list of users for a jQuery DataTable.
     *
     * @return JsonResponse
     */
    public function getAjaxDatatable(Request $request)
    {
        $input = $request->all();

        // Get the limit and offset
        $limit = isset($input['length']) ? (int) $input['length'] : 10;
        $offset = isset($input['start']) ? (int) $input['start'] : 0;

        // Get sort order
        $sortColumns = [
            'company_name',
            'full_name',
            'email',
            'phone',
            'mobile_phone',
            'role_id',
            'is_active'
        ];
        $sortColumns = $this->authUser->isAdmin() ? array_merge(['id', 'company_id'], $sortColumns) : array_merge(['id'], $sortColumns);

        $orderBy = isset($input['order'][0]) && isset($sortColumns[$input['order'][0]['column']]) ? $sortColumns[$input['order'][0]['column']] : 'id';
        $order = isset($input['order'][0]) ? $input['order'][0]['dir'] : 'desc';

        // Create search criteria
        $criteria['q'] = empty($input['search']['value']) ? NULL : $input['search']['value'];
        $criteria['company_id'] = $this->authUser->isAdmin() ? NULL : [$this->authUser->company_id];
        $criteria['count'] = TRUE;

        // Retrieve results
        $results = User::search($criteria, $offset, $limit, $orderBy, $order);

        // Process response
        $response = [];
        $response['recordsFiltered'] = $results['total'];
        $response['recordsTotal'] = $results['total'];
        $response['data'] = [];

        foreach($results['users'] as $user)
        {
            $data = [
                $user->company_name,
                $user->full_name,
                $user->email,
                $user->phone,
                $user->mobile_phone,
                $user->present()->role(),
                $user->is_active ? '<div class="badge badge-primary">Yes</div>' : '<div class="badge badge-danger">No</div>',
                sprintf('<a href="/accounts/edit/%s" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit</a>', $user->id)
            ];

            $data = $this->authUser->isAdmin() ? array_merge([$user->id, $user->company->name], $data) : array_merge([$user->id], $data);

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
        $input = $request->only('user', 'address');

        $input['user']['is_active'] = isset($input['user']['is_active']);
        $input['user']['company_id'] = $this->authUser->isAdmin() ? $input['user']['company_id'] : $this->authUser->company_id;

        if ( ! $this->authUser->isAdmin() && $input['user']['role_id'] == Role::ADMIN)
        {
            // Prohibit setting "admin" role
            $input['user']['role_id'] = NULL;
        }

        return $input;
    }
}
