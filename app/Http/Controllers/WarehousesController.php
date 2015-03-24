<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Warehouse;
use App\Helpers\Flash;

class WarehousesController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    /**
     * Displays a list of warehouses.
     */
    public function getIndex()
    {
        $warehouses = Warehouse::where('site_id', '=', $this->user->site_id)->get();
        return view('warehouses.index', ['warehouses' => $warehouses]);
    }

    /**
     * Shows the form for creating a warehouse.
     */
    public function getCreate()
    {
        return view('warehouses.form', ['warehouse' => new Warehouse()]);
    }
}
