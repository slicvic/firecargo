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

        return view('packages.index', [
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
     */
    public function getAjaxWarehousePackages(Request $request, $warehouseId)
    {
        $packages = Package::mine()
            ->with('type', 'shipment')
            ->where(['warehouse_id' => $warehouseId])
            ->orderBy('shipment_id', 'ASC')
            ->get();

        return view('packages.warehouse_packages', ['packages' => $packages]);
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

        return view('packages.shipment_packages', ['packages' => $packages]);
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
            $package = Package::where(['id' => $id, 'client_account_id' => $this->user->client->id])
                ->firstOrFail();

            return view('packages.client.detail_modal', ['package' => $package]);
        }

        $package = Package::findMineOrFail($id);

        return view('packages.detail_modal', ['package' => $package]);
    }
}
