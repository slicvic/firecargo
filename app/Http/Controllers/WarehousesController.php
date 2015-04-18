<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Warehouse;
use App\Models\Package;
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
        $warehouses = Warehouse::allByCurrentSiteId();
        return view('warehouses.index', ['warehouses' => $warehouses]);
    }

    /**
     * Displays a specific warehouse.
     */
    public function getView(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFailByIdAndSiteId($id, $this->user->site_id);

        return view('warehouses.view', ['warehouse' => $warehouse]);
    }

    /**
     * Shows the form for creating a warehouse.
     */
    public function getCreate()
    {
        return view('warehouses.form', ['warehouse' => new Warehouse()]);
    }

    /**
     * Creates a new warehouse.
     */
    public function postStore(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input['warehouse'], Warehouse::$rules);

        if ($validator->fails())
        {
            $view = view('flash_messages.error', ['message' => $validator])->render();
            return response()->json(['status' => 'error', 'message' => $view]);
        }
        else
        {
            // Create warehouse
            $input['warehouse']['arrived_at'] = date('Y-m-d H:i:s', strtotime($input['warehouse']['arrived_at']['date'] . ' ' . $input['warehouse']['arrived_at']['time']));

            $warehouse = Warehouse::create($input['warehouse']);

            // Create packages
            if (isset($input['package']) && count($input['package']))
            {
                foreach ($input['package'] as $package)
                {
                    $package['warehouse_id'] = $warehouse->id;
                    $package['status'] = $input['status_id'];
                    Package::create($package);
                }
            }

            return response()->json(['status' => 'ok', 'redirect_to' => '/warehouses/view/' . $warehouse->id]);
        }
    }

    /**
     * Shows the form for editing a warehouse.
     */
    public function getEdit($id)
    {
        $warehouse = Warehouse::findOrFailByIdAndSiteId($id, $this->user->site_id);
        return view('warehouses.form', ['warehouse' => $warehouse]);
    }

    /**
     * Updates a specific warehouse.
     */
    public function postUpdate(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input['warehouse'], Warehouse::$rules);

        if ($validator->fails())
        {
            $view = view('flash_messages.error', ['message' => $validator])->render();
            return response()->json(['status' => 'error', 'message' => $view]);
        }
        else
        {
            // Update warehouse
            $warehouse = Warehouse::findOrFailByIdAndSiteId($id, $this->user->site_id);

            if ( ! $warehouse)
            {
                return response()->json(['status' => 'error', 'message' => 'Invalid warehouse ID.']);
            }

            $input['warehouse']['arrived_at'] = date('Y-m-d H:i:s', strtotime($input['warehouse']['arrived_at']['date'] . ' ' . $input['warehouse']['arrived_at']['time']));

            $warehouse->update($input['warehouse']);

            // Update packages
            Package::where('warehouse_id', '=', $warehouse->id)->update(['deleted' => 1]);

            if (isset($input['package']) && count($input['package']))
            {
                foreach ($input['package'] as $package_id => $packageData)
                {
                    $packageData['warehouse_id'] = $warehouse->id;
                    $packageData['deleted'] = 0;
                    Package::firstOrCreate(['id' => $package_id])->update($packageData);
                }
            }

            return response()->json(['status' => 'ok', 'redirect_to' => '/warehouses/view/' . $warehouse->id]);
        }
    }
}
