<?php namespace App\Http\Controllers;

use Validator;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

use App\Models\Package;
use App\Http\ToastrJsonResponse;

/**
 * PackagesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class PackagesController extends BaseAuthController {

    /**
     * Constructor.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        parent::__construct($auth);

        $this->middleware('auth.agentOrHigher', ['except' => ['getCustomerPackageDetails']]);
    }

    /**
     * Shows a list of packages.
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
        $params['status'] = $request->input('status');

        $criteria['status'] = $params['status'];
        $criteria['search'] = $params['search'];
        $criteria['company_id'] = $this->user->isAdmin() ? NULL : $this->user->company_id;

        $packages = Package::search($criteria, $params['sort'], $params['order'], $params['limit']);

        return view('admin.packages.index', [
            'packages' => $packages,
            'params' => $params,
            'statuses' => [
                'unprocessed' => 'Unprocessed',
                'hold' => 'On Hold',
                'shipped' => 'Shipped'
            ]
        ]);
    }

    /**
     * Shows the packages for a specific warehouse.
     *
     * @param  Request  $request
     * @param  int      $warehouseId
     * @return Response
     * @uses   Ajax
     */
    public function getWarehousePackages(Request $request, $warehouseId)
    {
        $packages = Package::mine()
            ->with('type', 'shipment')
            ->where(['warehouse_id' => $warehouseId])
            ->orderBy('shipment_id', 'ASC')
            ->get();

        return view('admin.packages._warehouse_packages', ['packages' => $packages]);
    }

    /**
     * Shows the packages for a specific shipment.
     *
     * @param  Request  $request
     * @param  int      $warehouseId
     * @return Response
     * @uses   Ajax
     */
    public function getShipmentPackages(Request $request, $shipmentId)
    {
        $packages = Package::mine()
            ->with('type')
            ->where(['shipment_id' => $shipmentId])
            ->get();

        return view('admin.packages._shipment_packages', ['packages' => $packages]);
    }

    /**
     * Shows a specific package details.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Response
     * @uses   Ajax
     */
    public function getPackageDetails(Request $request, $id)
    {
        $package = Package::findMine($id);

        if ( ! $package)
        {
            return ToastrJsonResponse::error('Package not found.', 404);
        }

        return view('admin.packages._package_details', ['package' => $package]);
    }

    /**
     * Shows a specific package details.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Response
     * @uses   Ajax
     */
    public function getCustomerPackageDetails(Request $request, $id)
    {
        $package = Package::where([
            'id' => $id,
            'customer_account_id' => $this->user->account->id
        ])->first();


        if ( ! $package)
        {
            return ToastrJsonResponse::error('Package not found.', 404);
        }

        return view('admin.packages._customer_package_details', ['package' => $package]);
    }

    /**
     * Updates a jquery x-editable field.
     *
     * @param  Request  $request
     * @return JsonResponse
     * @uses   Ajax
     */
    public function postEditableField(Request $request)
    {
        $input = $request->only('pk', 'name', 'value');

        $rules = [
            'pk' => 'required',
            'name' => 'required',
            'value' => 'required'
        ];

        // Validate input
        $validator = Validator::make($input, $rules);

        if ($validator->fails())
        {
            return response()->json(implode(' ', $validator->messages()->all(':message')), 400);
        }

        // Validate field name
        $validFields = [
            'type_id',
            'length',
            'width',
            'height',
            'weight',
            'description',
            'invoice_number',
            'invoice_value',
            'tracking_number'
        ];

        if ( ! in_array($input['name'], $validFields))
        {
            return response()->json('Invalid field name.', 400);
        }

        // Find package
        $package = Package::findMine($input['pk']);

        if ( ! $package)
        {
            return response()->json('Package not found.', 404);
        }

        // Update package
        $package->$input['name'] = $input['value'];
        $package->save();

        return response()->json();
    }
}
