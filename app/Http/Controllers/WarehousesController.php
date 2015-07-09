<?php namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Http\JsonResponse;

use App\Models\Warehouse;
use App\Models\Package;
use App\Models\User;
use App\Models\Carrier;
use App\Helpers\Flash;

use Illuminate\Pagination\Paginator;
use App\Pdf\Warehouse as WarehousePdf;
use DB;

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
     * Displays a list of warehouses.
     */
    public function getIndex(Request $request)
    {
        // Prepare input
        $input['limit'] = $request->input('limit', 10);
        $input['sortby'] = $request->input('sortby', 'id');
        $input['order'] = $request->input('order', 'desc');
        $input['q'] = $request->input('q');
        $input['status'] = $request->input('status');

        // Perform search
        $criteria['status'] = $input['status'];
        $criteria['q'] = $input['q'];
        $criteria['company_id'] = $this->user->company_id;
        $warehouses = Warehouse::search($criteria, $input['sortby'], $input['order'], $input['limit']);

        return view('warehouses.index', [
            'warehouses' => $warehouses,
            'input' => $input,
            'orderInverse' => ($input['order'] === 'asc') ? 'desc' : 'asc',
        ]);
    }

    /**
     * Shows a specific warehouse.
     */
    public function getShow(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFailByIdAndCurrentCompany($id);
        return view('warehouses.show', ['warehouse' => $warehouse]);
    }

    /**
     * Shows the form for creating a warehouse.
     */
    public function getCreate()
    {
        return view('warehouses.form', ['warehouse' => new Warehouse]);
    }

    /**
     * Creates a new warehouse.
     */
    public function postStore(Request $request)
    {
        // Prepare and validate input
        $input = $this->prepareAndValidateInput($request);

        if ($input instanceof JsonResponse)
            return $input;

        // Create warehouse
        $warehouse = Warehouse::create($input['warehouse']);

        // Create packages
        $warehouse->syncPackages($input['packages'], FALSE);

        Flash::success('Warehouse created.');
        return response()->json(['status' => 'ok', 'redirect_to' => '/warehouses/show/' . $warehouse->id]);
    }

    /**
     * Shows the form for editing a warehouse.
     */
    public function getEdit($id)
    {
        $warehouse = Warehouse::findOrFailByIdAndCurrentCompany($id);
        return view('warehouses.form', ['warehouse' => $warehouse]);
    }

    /**
     * Updates a specific warehouse.
     */
    public function postUpdate(Request $request, $id)
    {
        // Lookup warehouse
        $warehouse = Warehouse::findByIdAndCurrentCompany($id);

        if ( ! $warehouse)
            return response()->json(['status' => 'error', 'message' => 'Warehouse not found.']);

        // Prepare and validate input
        $input = $this->prepareAndValidateInput($request);

        if ($input instanceof JsonResponse)
            return $input;

        // Update warehouse
        $warehouse->update($input['warehouse']);

        // Update packages
        $warehouse->syncPackages($input['packages']);

        Flash::success('Warehouse updated.');
        return response()->json(['status' => 'ok', 'redirect_to' => '/warehouses/edit/' . $warehouse->id]);
    }

    /**
     * Displays the warehouse receipt PDF.
     */
    public function getPrintReceipt(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        WarehousePdf::getReceipt($warehouse);
    }

    /**
     * Displays the warehouse shipping label PDF.
     */
    public function getPrintLabel(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        WarehousePdf::getLabel($warehouse);
    }

    /**
     * Retrieves a list of shippers & consignees for a jquery autocomplete field.
     *
     * @uses    ajax
     * @return  json
     */
    public function getAjaxShipperConsigneeAutocomplete(Request $request)
    {
        $input = $request->only('term', 'type');
        $response = [];

        if (strlen($input['term']) < 2)
            return response()->json($response);

        foreach(User::findForAutocomplete($input['term'], $this->user->company_id) as $user) {
            $response[] = [
                'id'    => $user->id,
                'label' => ('shipper' == $input['type']) ? $user->present()->company() : $user->present()->fullname()
            ];
        }

        return response()->json($response);
    }

    /**
     * Retrieves a list of carriers for a jquery autocomplete field.
     *
     * @uses    ajax
     * @return  json
     */
    public function getAjaxCarrierAutocomplete(Request $request)
    {
        $input = $request->only('term');
        $response = [];

        if (strlen($input['term']) < 2)
            return response()->json($response);

        foreach(Carrier::findForAutocomplete($input['term'], $this->user->company_id) as $carrier) {
            $response[] = [
                'id'    => $carrier->id,
                'label' => $carrier->name
            ];
        }

        return response()->json($response);
    }

    /**
     * Retrieves a list of packages by warehouse ID.
     * @deprecated
     */
    public function getAjaxPackages(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        return view('warehouses.index.packages', ['packages' => $warehouse->packages]);
    }

    /**
     * Validates and prepares the given request input.
     *
     * @param  Request $request
     * @return array  The input
     */
    private function prepareAndValidateInput(Request $request)
    {
        $input = $request->only('warehouse', 'packages');
        $input['warehouse']['company_id'] = $this->user->company_id;

        // Prepare rules
        $rules = Warehouse::$rules;
        $rules['carrier_name'] = 'required_without:carrier_id';
        $rules['carrier_id'] = 'required_without:carrier_name';

        // Validate input
        $validator = Validator::make($input['warehouse'], $rules);

        if ($validator->fails())
        {
            $message = view('flash_messages.error', [
                'message' => $validator->messages()->all(':message')
            ])->render();

            return response()->json(['status' => 'error', 'message' => $message]);
        }

        // Create new carrier if necessary
        if (empty($input['warehouse']['carrier_id']))
        {
            $carrier = Carrier::firstOrCreate([
                'company_id' => $this->user->company_id,
                'name' => strtoupper($input['warehouse']['carrier_name'])
            ]);

            $input['warehouse']['carrier_id'] = $carrier->id;
        }

        // Not a database field
        unset($input['warehouse']['carrier_name']);

        return $input;
    }
}
