<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

use App\Models\Package;

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

        $this->middleware('agent');
    }

    /**
     * Shows the packages for a specific warehouse.
     *
     * @return Response
     */
    public function getAjaxWarehousePackages(Request $request, $warehouseId)
    {
        $packages = Package::where(['warehouse_id' => $warehouseId, 'company_id' => $this->authUser->company_id])->get();

        return view('packages._list_warehouse', ['packages' => $packages]);
    }

    /**
     * Shows the packages for a specific shipment.
     *
     * @return Response
     */
    public function getAjaxShipmentPackages(Request $request, $shipmentId)
    {
        $packages = Package::where(['shipment_id' => $shipmentId, 'company_id' => $this->authUser->company_id])->get();

        return view('packages._list_shipment', ['packages' => $packages]);
    }
}
