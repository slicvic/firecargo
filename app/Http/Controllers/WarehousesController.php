<?php namespace App\Http\Controllers;

use Validator;
use Auth;
use DB;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;

use App\Models\Warehouse;
use App\Models\Package;
use App\Models\User;
use App\Models\Carrier;
use App\Helpers\Flash;
use App\Pdf\Warehouse as WarehousePdf;
use App\Exceptions\ValidationException;

/**
 * WarehousesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class WarehousesController extends BaseAuthController {

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
     * Displays a list of warehouses.
     *
     * @return Response
     */
    public function getIndex(Request $request)
    {
        // Prepare input
        $input['limit'] = $request->input('limit', 10);
        $input['sortby'] = $request->input('sortby', 'id');
        $input['order'] = $request->input('order', 'desc');
        $input['q'] = $request->input('q');
        $input['status'] = $request->input('status');

        // Perform query
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
     *
     * @return Response
     */
    public function getShow(Request $request, $id)
    {
        $warehouse = Warehouse::findOrFailByIdAndCurrentUserCompanyId($id);

        return view('warehouses.show', ['warehouse' => $warehouse]);
    }

    /**
     * Shows the form for creating a warehouse.
     *
     * @return Response
     */
    public function getCreate()
    {
        return view('warehouses.form', ['warehouse' => new Warehouse]);
    }

    /**
     * Creates a new warehouse.
     *
     * @return JsonResponse
     */
    public function postStore(Request $request)
    {
        // Prepare and validate input
        try
        {
            $input = $this->prepareAndValidateInput($request);
        }
        catch (ValidationException $e)
        {
            return response()->json(['error' => Flash::view($e)], 400);
        }

        // Create warehouse
        $warehouse = new Warehouse($input['warehouse']);
        $warehouse->company_id = $this->user->company_id;

        if ( ! $warehouse->save())
        {
            return response()->json(['error' => Flash::view('Warehouse creation failed, please try again.')], 500);
        }

        // Create packages
        $warehouse->syncPackages($input['packages'], FALSE);

        Flash::success('Warehouse created.');

        return response()->json(['redirect_url' => '/warehouses/show/' . $warehouse->id]);
    }

    /**
     * Shows the form for editing a warehouse.
     *
     * @return Response
     */
    public function getEdit($id)
    {
        $warehouse = Warehouse::findOrFailByIdAndCurrentUserCompanyId($id);
        return view('warehouses.form', ['warehouse' => $warehouse]);
    }

    /**
     * Updates a specific warehouse.
     *
     * @return JsonResponse
     */
    public function postUpdate(Request $request, $id)
    {
        // Lookup warehouse
        $warehouse = Warehouse::findByIdAndCurrentUserCompanyId($id);

        if ( ! $warehouse)
        {
            return response()->json(['error' => Flash::view('Warehouse not found.')], 404);
        }

        // Prepare and validate input
        try
        {
            $input = $this->prepareAndValidateInput($request);
        }
        catch (ValidationException $e)
        {
            return response()->json(['error' => Flash::view($e)], 400);
        }

        // Update warehouse
        $warehouse->update($input['warehouse']);

        // Update packages
        $warehouse->syncPackages($input['packages']);

        Flash::success('Warehouse updated.');

        return response()->json(['redirect_url' => '/warehouses/edit/' . $warehouse->id]);
    }

    /**
     * Displays the warehouse receipt PDF.
     *
     * @return void
     */
    public function getPrintReceipt(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFailByIdAndCurrentUserCompanyId($warehouseId);
        WarehousePdf::getReceipt($warehouse);
    }

    /**
     * Displays the warehouse shipping label PDF.
     *
     * @return void
     */
    public function getPrintLabel(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFailByIdAndCurrentUserCompanyId($warehouseId);
        WarehousePdf::getLabel($warehouse);
    }

    /**
     * Retrieves a list of shippers & consignees for a jquery autocomplete field.
     *
     * @return JsonResponse
     */
    public function getAjaxShipperConsigneeAutocomplete(Request $request)
    {
        $input = $request->only('term');
        $response = [];

        if (strlen($input['term']) < 2)
        {
            return response()->json($response);
        }

        foreach(User::autocompleteSearch($input['term'], $this->user->company_id) as $user)
        {
            $response[] = ['id' => $user->id, 'label' => $user->present()->company(TRUE)];
        }

        return response()->json($response);
    }

    /**
     * Retrieves a list of packages by warehouse id.
     *
     * @return Response
     */
    public function getAjaxPackages(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);
        return view('warehouses.index.packages', ['packages' => $warehouse->packages]);
    }

    /**
     * Validates and prepares the given request input for creating and updating
     * a warehouse.
     *
     * @param  Request $request
     * @return array
     * @throws ValidationException
     */
    private function prepareAndValidateInput(Request $request)
    {
        $input = $request->only('warehouse', 'packages');

        // Prepare rules
        $warehouseRules = [
            'shipper_user_id' => 'required',
            'consignee_user_id' => 'required',
            'arrived_at' => 'required',
            'carrier_id' => 'required_without:carrier_name',
            'carrier_name' => 'required_without:carrier_id',
        ];

        // Validate input
        $validator = Validator::make($input['warehouse'], $warehouseRules);

        if ($validator->fails())
        {
            throw new ValidationException($validator->messages(), 400);
        }

        // Create a new carrier if necessary
        if (empty($input['warehouse']['carrier_id']))
        {
            $carrier = Carrier::firstOrCreate(['name' => $input['warehouse']['carrier_name']]);
            $input['warehouse']['carrier_id'] = $carrier->id;
        }

        // Not a real attribute
        unset($input['warehouse']['carrier_name']);

        return $input;
    }
}
