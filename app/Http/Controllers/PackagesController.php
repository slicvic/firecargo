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

        $this->middleware('agent', ['except' => ['getAjaxShow']]);
    }

    /**
     * Shows the packages for a specific warehouse.
     *
     * @param  Request  $request
     * @param  int      $warehouseId
     * @return Response
     */
    public function getAjaxWarehousePackages(Request $request, $warehouseId)
    {
        $packages = Package::mine()
            ->with('type', 'shipment')
            ->where(['warehouse_id' => $warehouseId])
            ->orderBy('shipment_id', 'ASC')
            ->get();

        return view('packages._warehouse_packages', ['packages' => $packages]);
    }

    /**
     * Shows the packages for a specific shipment.
     *
     * @param  Request  $request
     * @param  int      $warehouseId
     * @return Response
     */
    public function getAjaxShipmentPackages(Request $request, $shipmentId)
    {
        $packages = Package::mine()
            ->with('type')
            ->where(['shipment_id' => $shipmentId])
            ->get();

        return view('packages._shipment_packages', ['packages' => $packages]);
    }

    /**
     * Shows a specific package.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return Response
     */
    public function getAjaxDetail(Request $request, $id)
    {
        if ($this->user->isClient())
        {
            $package = Package::findOrFailByIdAndClientAccountId($id, $this->user->client->id);

            return view('packages.client._detail_modal', ['package' => $package]);
        }

        $package = Package::findMineOrFail($id);

        return view('packages._detail_modal', ['package' => $package]);
    }
}
