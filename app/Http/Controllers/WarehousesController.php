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
use App\Models\PackageStatus;
use App\Models\PackageType;
use App\Models\Account;

use App\Models\Role;
use App\Models\Carrier;
use App\Pdf\Warehouse as WarehousePdf;
use App\Exceptions\ValidationException;
use Flash;

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
     * @param  Request  $request
     * @return Response
     */
    public function getIndex(Request $request)
    {
        // Extract input
        $input['limit'] = $request->input('limit', 10);
        $input['sort'] = $request->input('sort', 'id');
        $input['order'] = $request->input('order', 'DESC');
        $input['q'] = $request->input('q');
        $input['status'] = $request->input('status');

        // Prepare search criteria
        $criteria['status'] = $input['status'];
        $criteria['q'] = $input['q'];
        $criteria['company_id'] = $this->authUser->isAdmin() ? NULL : $this->authUser->company_id;

        // Run query
        $warehouses = Warehouse::search($criteria, $input['sort'], $input['order'], $input['limit']);

        return view('warehouses.index', [
            'warehouses' => $warehouses,
            'input' => $input,
            'oppositeOrder' => ($input['order'] === 'asc') ? 'desc' : 'asc',
        ]);
    }

    /**
     * Shows a specific warehouse.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Response
     */
    public function getShow(Request $request, $id)
    {
        $warehouse = Warehouse::find($id);

        if ( ! $warehouse)
        {
            return $this->redirectBackWithError('Warehouse not found.');
        }

        return view('warehouses.show', ['warehouse' => $warehouse]);
    }

    /**
     * Shows the form for creating a warehouse.
     *
     * @return Response
     */
    public function getCreate()
    {
        return $this->getEditForm(new Warehouse);
    }

    /**
     * Creates a new warehouse.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function postStore(Request $request)
    {
        // Prepare and validate input
        try
        {
            $input = $this->prepareAndValidate($request);
        }
        catch (ValidationException $e)
        {
            return response()->json(['error' => Flash::view($e)], 400);
        }

        // Create warehouse
        $warehouse = new Warehouse;
        $warehouse->arrived_at = date('Y-m-d H:i:s', strtotime($input['warehouse']['date'] . ' ' . $input['warehouse']['time']));
        $warehouse->shipper_account_id = $input['warehouse']['shipper_account_id'];
        $warehouse->consignee_account_id = $input['warehouse']['consignee_account_id'];
        $warehouse->carrier_id = $input['warehouse']['carrier_id'];

        if ( ! $warehouse->save())
        {
            return response()->json(['error' => Flash::view('Warehouse creation failed, please try again.')], 500);
        }

        // Create packages
        if ($input['packages'])
        {
            $warehouse->createOrUpdatePackages($input['packages']);
        }

        Flash::success('Warehouse created.');

        return response()->json(['redirect_url' => '/warehouses/show/' . $warehouse->id]);
    }

    /**
     * Shows the form for editing a warehouse.
     *
     * @param  int  $id
     * @return Response
     */
    public function getEdit($id)
    {
        $warehouse = Warehouse::find($id);

        if ( ! $warehouse)
        {
            return $this->redirectBackWithError('Warehouse not found.');
        }

        return $this->getEditForm($warehouse);
    }

    /**
     * Updates a specific warehouse.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return JsonResponse
     */
    public function postUpdate(Request $request, $id)
    {
        // Find warehouse
        $warehouse = Warehouse::find($id);

        if ( ! $warehouse)
        {
            return response()->json(['error' => Flash::view('Warehouse not found.')], 404);
        }

        // Prepare and validate input
        try
        {
            $input = $this->prepareAndValidate($request);
        }
        catch (ValidationException $e)
        {
            return response()->json(['error' => Flash::view($e)], 400);
        }

        // Update warehouse
        $warehouse->arrived_at = date('Y-m-d H:i:s', strtotime($input['warehouse']['date'] . ' ' . $input['warehouse']['time']));
        $warehouse->shipper_account_id = $input['warehouse']['shipper_account_id'];
        $warehouse->consignee_account_id = $input['warehouse']['consignee_account_id'];
        $warehouse->carrier_id = $input['warehouse']['carrier_id'];
        $warehouse->save();

        // Update packages
        if ($input['packages'])
        {
            $warehouse->createOrUpdatePackages($input['packages']);
        }

        Flash::success('Warehouse updated.');

        return response()->json(['redirect_url' => '/warehouses/edit/' . $warehouse->id]);
    }

    /**
     * Displays the warehouse receipt PDF.
     *
     * @param  Request  $request
     * @param  int      $warehouseId
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
     * @param  Request  $request
     * @param  int      $warehouseId
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
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getAjaxShipperConsigneeAutocomplete(Request $request)
    {
        $input = $request->only('term');
        $response = [];

        if (strlen($input['term']) < 2)
        {
            // Return nothing
            return response()->json($response);
        }

        $accounts = Account::autocompleteSearch($input['term'])->mine()->limit(25)->get();

        foreach($accounts as $account)
        {
            $response[] = [
                'id'    => $account->id,
                'label' => $account->present()->name()
            ];
        }

        return response()->json($response);
    }

    /**
     * Creates the form for creating and editing a warehouse.
     *
     * @param  Warehouse $warehouse
     * @return View
     */
    private function getEditForm(Warehouse $warehouse)
    {
        return view('warehouses.edit', [
            'warehouse'       => $warehouse,
            'packageStatuses' => PackageStatus::mine()->orderBy('default', 'DESC')->get(),
            'packageTypes'    => PackageType::orderBy('name', 'ASC')->get()
        ]);
    }

    /**
     * Validates and prepares the given request input for creating and updating
     * a warehouse.
     *
     * @param  Request $request
     * @return array
     * @throws ValidationException
     */
    private function prepareAndValidate(Request $request)
    {
        $input = $request->only('warehouse', 'packages');

        // Prepare rules
        $warehouseRules = [
            'shipper_name' => 'required|min:3',
            'consignee_name' => 'required|min:5',
            'carrier_name' => 'required|min:3',
            'date' => 'required',
            'time' => 'required',
        ];

        // Validate input
        $validator = Validator::make($input['warehouse'], $warehouseRules);

        if ($validator->fails())
        {
            throw new ValidationException($validator->messages());
        }

        // Create a new carrier if necessary
        if (empty($input['warehouse']['carrier_id']))
        {
            $carrier = Carrier::firstOrCreate(['name' => $input['warehouse']['carrier_name']]);

            $input['warehouse']['carrier_id'] = $carrier->id;
        }

        // Create a new shipper account if necessary
        if (empty($input['warehouse']['shipper_account_id']))
        {
            $shipper = User::firstOrCreate([
                'company_name' => trim($input['warehouse']['shipper_name']),
                'company_id' => $this->authUser->company_id,
                'role_id' => Role::SHIPPER
            ]);

            $input['warehouse']['shipper_account_id'] = $shipper->id;
        }

        // Create a new consignee account if necessary
        if (empty($input['warehouse']['consignee_account_id']))
        {
            $consignee = User::firstOrCreate([
                'full_name' => trim($input['warehouse']['consignee_name']),
                'company_id' => $this->authUser->company_id,
                'role_id' => Role::CLIENT
            ]);

            $input['warehouse']['consignee_account_id'] = $consignee->id;
        }

        return $input;
    }
}
