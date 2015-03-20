<?php

class AdminWarehousesController extends AdminBaseController {

    protected $layout = 'admin.layouts.default';

    public function anyIndex()
    {
        $this->layout->content = View::make('admin.warehouses.index');
    }

    public function getAutocompleteUser()
    {
        $input = Input::all();
        $response = array();

        if ( ! empty($input['term'])) {
            foreach(User::getAutocomplete($input['term']) as $user) {
                $response[] = array(
                    'id' => $user->id,
                    'company' => $user->company,
                    'name' => $user->name()
                );
            }
        }

        return Response::json($response);
    }

    public function anyNew()
    {
        $this->layout->content = View::make('admin.warehouses.form')
            ->with('wh', new Warehouse());
    }
}
