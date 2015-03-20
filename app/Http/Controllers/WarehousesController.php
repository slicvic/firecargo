<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Warehouse;
use App\Models\User;
use App\Helpers\Flash;

class WarehousesController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('merchant');
    }

    /**
     * Displays a list of warehouses.
     */
    public function getIndex()
    {
        $warehouses = Warehouse::where('company_id', '=', Auth::user()->company_id)->get();
        return view('warehouses.index', ['warehouses' => $warehouses]);
    }

    /**
     * Shows the form for creating a warehouse.
     */
    public function getCreate()
    {
        return view('warehouses.form', ['warehouse' => new Warehouse()]);
    }

    public function getAutocompleteUser(Request $request)
    {
        $input = $request->all();
        $response = array();

        if ( ! empty($input['term'])) {
            foreach(User::getAutocomplete($input['term']) as $user) {
                $response[] = array(
                    'id' => $user->id,
                    'company' => $user->company_name,
                    'name' => $user->name()
                );
            }
        }

        return response()->json($response);
    }
}
