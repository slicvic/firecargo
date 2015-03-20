<?php

class AdminUsersController extends AdminBaseController {
    /**
     * Displays list of users.
     */
    public function getIndex()
    {
        $input = Input::only('orderby', 'order');
        $order = ($input['order'] === 'asc') ? 'asc' : 'desc';
        $order_by = in_array($input['orderby'], ['id', 'company', 'firstname', 'lastname', 'email']) ? $input['orderby'] : 'id';
        $per_page = 30;

        $users = User::whereRaw(1)
            ->orderBy($order_by, $order)
            ->paginate($per_page);

        $view = View::make('admin.users.index')
            ->with('users', $users)
            ->with('order', ($order == 'asc' ? 'desc' : 'asc'))
            ->with('orderby', $order_by);

        $this->layout->content = $view;
    }

    /**
     * Gets data for jQuery Datatable.
     *
     * @uses    ajax
     * @return  json
     */
    public function getAjaxDatatable()
    {
        $input = Input::all();

        // Get limit and offset
        $offset = isset($input['start']) ? (int) $input['start'] : 0;
        $limit = isset($input['length']) ? (int) $input['length'] : 10;

        // Get sort column and direction
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
        $search = empty($input['search']['value']) ? NULL : $input['search']['value'];

        // Run query
        $results = User::getDatatable($search, FALSE, $offset, $limit, $order_by, $order);
        $total = User::getDatatable($search, TRUE);

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
                sprintf('<a href="/admin/users/edit/%s" class="btn btn-default"><i class="fa fa-edit"></i></a>', $record->id)
            );
        }
        return Response::json($response);
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
     * Updates the given user.
     *
     * @uses ajax
     */
    public function anyEdit($id = NULL)
    {
        $user = User::find($id);

        if (Request::isMethod('post')) {
            $response = ['success' => FALSE];
            $input = Input::all();
            $validator = Validator::make(
                $input['user'], [
                    'email' => 'email|unique:users,email,' . $id
                ]
            );

            if ($validator->fails()) {
                $response['error_message'] = $validator->messages()->first('email');
            }
            else {
                $response['success'] = TRUE;
                $response['redirect_to'] = '/admin/users';
                $user->update($input['user']);
                $user->attachRoles((isset($input['roles']) ? $input['roles'] : array()));
            }

            return Response::json($response);
        }
        else {
            $this->layout->content = View::make('admin.users.form')
                ->with('user', $user);
        }
    }
}
