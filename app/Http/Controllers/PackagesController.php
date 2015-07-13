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
        $packages = Package::where(['warehouse_id' => $warehouseId, 'company_id' => $this->user->company_id])->get();

        return view('packages.index_ajax', ['packages' => $packages]);
    }

    /**
     * Shows the packages for a specific cargo.
     *
     * @return Response
     */
    public function getAjaxCargoPackages(Request $request, $cargoId)
    {
        $packages = Package::where(['cargo_id' => $cargoId, 'company_id' => $this->user->company_id])->get();

        return view('packages.index_ajax', ['packages' => $packages]);
    }
}
