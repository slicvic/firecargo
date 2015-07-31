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
use App\Models\PackageType;
use App\Models\Account;
use App\Models\AccountType;
use App\Models\Carrier;
use App\Pdf\WarehousePdf;
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
     * Shows a list of warehouses.
     *
     * @param  Request  $request
     * @return Response
     */
    public function getIndex(Request $request)
    {
        $params['limit'] = $request->input('limit', 10);
        $params['sort'] = $request->input('sort', 'id');
        $params['order'] = $request->input('order', 'desc');
        $params['search'] = $request->input('search');
        $params['status_id'] = $request->input('status_id');

        $criteria['status_id'] = $params['status_id'];
        $criteria['search'] = $params['search'];
        $criteria['company_id'] = $this->user->isAdmin() ? NULL : $this->user->company_id;

        $warehouses = Warehouse::search($criteria, $params['sort'], $params['order'], $params['limit']);

        return view('warehouses.index', [
            'warehouses' => $warehouses,
            'params' => $params
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
        $warehouse = Warehouse::findMineOrFail($id);

        return view('warehouses.show', ['warehouse' => $warehouse]);
    }

    /**
     * Shows the form for creating a new warehouse.
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
        $warehouse = new Warehouse;

        // Validate input and save warehouse
        if ( ! $this->validateAndSave($request, $warehouse))
        {
            return response()->json(['error' => Flash::view('Warehouse creation failed, please try again.')], 500);
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
        $warehouse = Warehouse::findMineOrFail($id);

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
        $warehouse = Warehouse::findMine($id);

        if ( ! $warehouse)
        {
            return response()->json(['error' => Flash::view('Warehouse not found.')], 404);
        }

        // Validate input and save warehouse
        if ( ! $this->validateAndSave($request, $warehouse))
        {
            return response()->json(['error' => Flash::view('Warehouse update failed, please try again.')], 500);
        }

        Flash::success('Warehouse updated.');

        return response()->json(['redirect_url' => '/warehouses/edit/' . $warehouse->id]);
    }

    /**
     * Shows the warehouse receipt PDF.
     *
     * @param  Request  $request
     * @param  int      $warehouseId
     * @return void
     */
    public function getPrintReceipt(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findMine($warehouseId);

        if ( ! $warehouse)
        {
            return $this->redirectBackWithError('Warehouse not found.');
        }

        WarehousePdf::getReceipt($warehouse);
    }

    /**
     * Shows the warehouse shipping label PDF.
     *
     * @param  Request  $request
     * @param  int      $warehouseId
     * @return void
     */
    public function getPrintLabel(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findMine($warehouseId);

        if ( ! $warehouse)
        {
            return $this->redirectBackWithError('Warehouse not found.');
        }

        WarehousePdf::getLabel($warehouse);
    }

    /**
     * Retrieves client or shipper accounts for an autocomplete field.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getAjaxAccountAutocomplete(Request $request)
    {
        $input = $request->only('term', 'type');

        if (strlen($input['term']) < 2)
        {
            return response()->json([]);
        }

        $accountTypeId = ($input['type'] === 'shipper') ? AccountType::SHIPPER : AccountType::CLIENT;
        $accounts = Account::autocompleteSearch($input['term'], $accountTypeId)->mine()->limit(25)->get();

        $response = [];

        foreach($accounts as $account)
        {
            $response[] = [
                'id'    => $account->id,
                'label' => $account->name
            ];
        }

        return response()->json($response);
    }

    /**
     * Creates the form for creating and editing a warehouse.
     *
     * @param  Warehouse  $warehouse
     * @return View
     */
    private function getEditForm(Warehouse $warehouse)
    {
        return view('warehouses.edit', [
            'warehouse'       => $warehouse,
            'packageTypes'    => PackageType::orderBy('name', 'ASC')->get()
        ]);
    }

    /**
     * Validates the given input and applies it to the warehouse.
     *
     * @param  Request    $request
     * @param  Warehouse  $warehouse
     * @return array
     * @throws ValidationException
     */
    private function validateAndSave(Request $request, Warehouse $warehouse)
    {
        $input = $request->only('warehouse', 'packages');

        // Validate input
        $rules = [
            'shipper' => 'required|min:3',
            'client' => 'required|min:5',
            'carrier' => 'required|min:3',
        ];

        $validator = Validator::make($input['warehouse'], $rules);

        if ($validator->fails())
        {
            throw new ValidationException($validator->messages());
        }

        // Create a new carrier if necessary
        if (empty($input['warehouse']['carrier_id']))
        {
            $carrier = Carrier::firstOrCreate(['name' => $input['warehouse']['carrier']]);

            $input['warehouse']['carrier_id'] = $carrier->id;
        }

        // Create a new shipper account if necessary
        if (empty($input['warehouse']['shipper_account_id']))
        {
            $shipper = Account::firstOrCreate([
                'name' => trim($input['warehouse']['shipper']),
                'company_id' => $this->user->company_id,
                'type_id' => AccountType::SHIPPER
            ]);

            $input['warehouse']['shipper_account_id'] = $shipper->id;
        }

        // Create a new client account if necessary
        if (empty($input['warehouse']['client_account_id']))
        {
            $client = Account::firstOrCreate([
                'name' => trim($input['warehouse']['client']),
                'company_id' => $this->user->company_id,
                'type_id' => AccountType::CLIENT
            ]);

            $input['warehouse']['client_account_id'] = $client->id;
        }

        // Save warehouse
        $warehouse->shipper_account_id = $input['warehouse']['shipper_account_id'];
        $warehouse->client_account_id = $input['warehouse']['client_account_id'];
        $warehouse->carrier_id = $input['warehouse']['carrier_id'];
        $warehouse->notes = $input['warehouse']['notes'];

        if ( ! $warehouse->save())
        {
            return FALSE;
        }

        // Save packages
        if ($input['packages'])
        {
            $warehouse->createOrUpdatePackages($input['packages']);
        }

        return TRUE;
    }
}
