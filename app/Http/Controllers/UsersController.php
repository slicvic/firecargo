<?php namespace App\Http\Controllers;

use Validator;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

use App\Models\User;
use App\Helpers\Flash;
use App\Helpers\Html;

class UsersController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    /**
     * Displays a list of users.
     */
    public function getIndex(Request $request)
    {
        return view('users.index');
    }

    /**
     * Returns a list of users for a jquery autocomple field.
     *
     * @uses    ajax
     * @return  json
     */
    public function getAutocomplete(Request $request)
    {
        $input = $request->all();
        $response = array();

        if ( ! empty($input['term']))
        {
            foreach(User::getAutocomplete($input['term'], array($this->user->site_id)) as $user)
            {
                $response[] = array(
                    'id' => $user->id,
                    'company' => $user->company,
                    'name' => $user->name()
                );
            }
        }

        return response()->json($response);
    }

    /**
     * Returns a list of users for a jquery datatable.
     *
     * @uses    ajax
     * @return  json
     */
    public function getDatatable(Request $request)
    {
        $input = $request->all();

        // Get limit and offset
        $limit = isset($input['length']) ? (int) $input['length'] : 10;
        $offset = isset($input['start']) ? (int) $input['start'] : 0;

        // Get sort order
        $columns = array(
            'id',
            'company',
            'firstname',
            'lastname',
            'email',
            'phone',
            'cellphone'
        );
        $orderBy = isset($input['order'][0]) && isset($columns[$input['order'][0]['column']]) ? $columns[$input['order'][0]['column']] : 'id';
        $order = isset($input['order'][0]) ? $input['order'][0]['dir'] : 'desc';
        $query = empty($input['search']['value']) ? NULL : $input['search']['value'];

        // Retrieve users
        $siteIds = ($this->user->isAdmin()) ? NULL : array($this->user->site_id);
        $results = User::getDatatable($query, $siteIds, FALSE, $offset, $limit, $orderBy, $order);
        $total = User::getDatatable($query, $siteIds, TRUE);

        // Process response
        $response = array();
        $response['recordsFiltered'] = $total;
        $response['data'] = array();

        foreach($results as $user) {
            $company = $user->company;
            $response['data'][] = array(
                $user->id,
                $user->site->name,
                $user->company,
                $user->firstname,
                $user->lastname,
                $user->email,
                $user->phone,
                $user->cellphone,
                Html::arrayToLabels($user->rolesArray()),
                sprintf('<a href="/accounts/edit/%s" class="btn btn-flat icon"><i class="fa fa-pencil"></i></a>', $user->id)
            );
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
        $input = $request->all();

        $rules = User::$rules;
        unset($rules['password']);

        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $input['site_id'] = ($this->user->isAdmin()) ? $input['site_id'] : $this->user->site_id;

        $user = User::create($input['user']);

        if (isset($input['roles']))
        {
            $user->attachRoles($input['roles']);
        }

        Flash::success('Saved');

        return redirect('accounts');
    }

    /**
     * Shows the form for editing a user.
     */
    public function getEdit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('users.form', ['user' => $user]);
    }

    /**
     * Updates a specific user.
     */
    public function postUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->all();

        $rules = User::$rules;
        $rules['email'] .= ',' . $id;
        // Ignore empty passwords
        unset($rules['password']);

        $validator = Validator::make($input['user'], $rules);

        if ($validator->fails())
        {
            Flash::error($validator->messages());
            return redirect()->back()->withInput();
        }

        $user->update($input['user']);
        $user->attachRoles((isset($input['roles']) ? $input['roles'] : array()));

        Flash::success('Saved');

        return redirect('accounts');
    }
}
