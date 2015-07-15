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
use App\Models\User;
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
     * @return Response
     */
    public function getIndex(Request $request)
    {
        $input['limit'] = $request->input('limit', 10);
        $input['sort'] = $request->input('sort', 'id');
        $input['order'] = $request->input('order', 'desc');
        $input['q'] = $request->input('q');
        $input['status'] = $request->input('status');

        // Prepare search criteria
        $criteria['status'] = $input['status'];
        $criteria['q'] = $input['q'];
        $criteria['company_id'] = $this->authUser->company_id;

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
        return view('warehouses.edit', [
            'warehouse' => new Warehouse,
            'packageStatuses' => PackageStatus::allByCurrentUserCompanyId('is_default', 'desc'),
            'packageTypes' => PackageType::all()
        ]);
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
        $warehouse = new Warehouse;
        $warehouse->arrived_at = date('Y-m-d H:i:s', strtotime($input['warehouse']['date'] . ' ' . $input['warehouse']['time']));
        $warehouse->shipper_user_id = $input['warehouse']['shipper_user_id'];
        $warehouse->consignee_user_id = $input['warehouse']['consignee_user_id'];
        $warehouse->carrier_id = $input['warehouse']['carrier_id'];
        $warehouse->company_id = $this->authUser->company_id;

        if ( ! $warehouse->save())
        {
            return response()->json(['error' => Flash::view('Warehouse creation failed, please try again.')], 500);
        }

        // Create packages
        if ($input['packages'])
        {
            $warehouse->syncPackages($input['packages'], FALSE);
        }

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

        return view('warehouses.edit', [
            'warehouse' => $warehouse,
            'packageStatuses' => PackageStatus::allByCurrentUserCompanyId('is_default', 'desc'),
            'packageTypes' => PackageType::all()
        ]);
    }

    /**
     * Updates a specific warehouse.
     *
     * @return JsonResponse
     */
    public function postUpdate(Request $request, $id)
    {
        // Make sure warehouse exists before proceeding
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
        $warehouse->arrived_at = date('Y-m-d H:i:s', strtotime($input['warehouse']['date'] . ' ' . $input['warehouse']['time']));
        $warehouse->shipper_user_id = $input['warehouse']['shipper_user_id'];
        $warehouse->consignee_user_id = $input['warehouse']['consignee_user_id'];
        $warehouse->carrier_id = $input['warehouse']['carrier_id'];
        $warehouse->save();

        // Update packages
        $warehouse->syncPackages($input['packages'] ?: []);

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

        // Return nothing if search term does not meet length requirement
        if (strlen($input['term']) < 2)
        {
            return response()->json([]);
        }

        // Prepare search criteria
        $criteria['q'] = $input['term'];
        $criteria['company_id'] = [$this->authUser->company_id];

        // Run query
        $users = User::search($criteria, 0, 25);

        $response = [];

        foreach($users as $user)
        {
            $response[] = [
                'id' => $user->id,
                'label' => $user->present()->company()
            ];
        }

        return response()->json($response);
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
        if (empty($input['warehouse']['shipper_user_id']))
        {
            $shipper = User::firstOrCreate([
                'company_name' => $input['warehouse']['shipper_name'],
                'company_id' => $this->authUser->company_id,
                'role_id' => Role::SHIPPER
            ]);

            $input['warehouse']['shipper_user_id'] = $shipper->id;
        }

        // Create a new consignee account if necessary
        if (empty($input['warehouse']['consignee_user_id']))
        {
            $consignee = User::firstOrCreate([
                'full_name' => $input['warehouse']['consignee_name'],
                'company_id' => $this->authUser->company_id,
                'role_id' => Role::CLIENT
            ]);

            $input['warehouse']['consignee_user_id'] = $consignee->id;
        }

        return $input;
    }
}
