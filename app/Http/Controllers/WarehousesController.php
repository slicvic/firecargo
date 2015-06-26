<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Models\Warehouse;
use App\Models\Package;
use App\Models\User;
use App\Helpers\Flash;

use Illuminate\Pagination\Paginator;
use App\Pdf\Warehouse as WarehousePdf;

/**
 * WarehousesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class WarehousesController extends BaseAuthController {

    public function __construct(Guard $auth)
    {
        parent::__construct($auth);
        $this->middleware('agent');
    }

    /**
     * Shows a list of warehouses.
     */
    public function getIndex(Request $request)
    {
        $perPage = $request->input('limit', 10);
        $searchTerm = $request->input('q');
        $sortBy = $request->input('sortby', 'id');
        $sortOrder = $request->input('order', 'desc');

        $warehouses = Warehouse::where('site_id', '=', $this->user->site_id)
            ->where('deleted', '<>', 1)
           // ->join('users u1', 'w.consignee_user_id', '=', 'u1.id')
           // ->whereRaw('w.id > 0 AND w.id < ?', [2])
            ->orderBy(array_key_exists($sortBy, Warehouse::$sortColumns) ? Warehouse::$sortColumns[$sortBy] : 'id', $sortOrder)
            ->paginate($perPage);

        return view('warehouses.index', [
            'warehouses' => $warehouses,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
            'reverseSortOrder' => ($sortOrder === 'asc' ? 'desc' : 'asc'),
        ]);
    }

    /**
     * Shows a specific warehouse.
     */
    public function getView(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFailByIdAndCurrentSiteId($id);

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

        $consignee = User::find($input['warehouse']['consignee_user_id']);

        // Create warehouse
        $input['warehouse']['arrived_at'] = date('Y-m-d H:i:s', strtotime($input['warehouse']['arrived_at']['date'] . ' ' . $input['warehouse']['arrived_at']['time']));
        $warehouse = Warehouse::create($input['warehouse']);

        // Create packages
        if ( ! empty($input['package']))
        {
            foreach ($input['package'] as $package)
            {
                $package['warehouse_id'] = $warehouse->id;
                $package['roll'] = $consignee->autoroll_packages;
                Package::create($package);
            }
        }

        return response()->json(['status' => 'ok', 'redirect_to' => '/warehouses/view/' . $warehouse->id]);
    }

    /**
     * Shows the form for editing a warehouse.
     */
    public function getEdit($id)
    {
        $warehouse = Warehouse::findOrFailByIdAndCurrentSiteId($id);
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

        // Update warehouse
        $warehouse = Warehouse::findByIdAndCurrentSiteId($id);

        if ( ! $warehouse)
        {
            return response()->json(['status' => 'error', 'message' => 'Invalid warehouse ID.']);
        }

        $input['warehouse']['arrived_at'] = date('Y-m-d H:i:s', strtotime($input['warehouse']['arrived_at']['date'] . ' ' . $input['warehouse']['arrived_at']['time']));
        $warehouse->update($input['warehouse']);

        // Update packages
        Package::where('warehouse_id', '=', $warehouse->id)->update(['deleted' => 1]);

        if ( ! empty($input['package']))
        {
            foreach ($input['package'] as $packageId => $packageData)
            {
                $packageData['warehouse_id'] = $warehouse->id;
                $packageData['deleted'] = 0;
                Package::firstOrCreate(['id' => $packageId])->update($packageData);
            }
        }

        return response()->json(['status' => 'ok', 'redirect_to' => '/warehouses/view/' . $warehouse->id]);
    }

    /**
     * Displays the warehouse receipt PDF.
     */
    public function getPrintReceipt(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        WarehousePdf::getReceipt($warehouseId);
    }

    /**
     * Displays the warehouse shipping label PDF.
     */
    public function getPrintLabel(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        WarehousePdf::getLabel($warehouseId);
    }

    /**
     * Retrieves a list of packages by warehouse ID.
     */
    public function getAjaxPackages(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        return view('warehouses.index.packages', ['packages' => $warehouse->packages()]);
    }

    /**
     * Returns a list of users for a jQuery autocomple field.
     *
     * @uses    ajax
     * @return  json
     */
    public function getAjaxAutocompleteAccount(Request $request)
    {
        $input = $request->only('term', 'type');
        $response = [];

        if (strlen($input['term']) > 1)
        {
            foreach(User::getUsersForAutocomplete($input['term'], [$this->user->site_id]) as $user)
            {
                $response[] = [
                    'id' => $user->id,
                    'label' => ($input['type'] == 'shipper') ? $user->business_name : $user->getFullName()
                ];
            }
        }

        return response()->json($response);
    }
}
