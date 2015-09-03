<?php

namespace App\Http\Controllers\Admin;

use Validator;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\Paginator;

use App\Models\Warehouse;
use App\Models\WarehouseStatus;
use App\Models\PackageType;
use App\Services\Pdf\WarehousePdfService;
use App\Exceptions\ValidationException;
use Flash;

/**
 * WarehousesController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class WarehousesController extends BaseAdminController {

    /**
     * Constructor.
     *
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        parent::__construct($auth);

        $this->middleware('auth.agentOrHigher');
    }

    /**
     * Show a list of warehouses.
     *
     * @param  Request  $request
     * @return View
     */
    public function getIndex(Request $request)
    {
        $params['limit'] = 10;
        $params['sort'] = $request->input('sort', 'id');
        $params['order'] = $request->input('order', 'desc');
        $params['search'] = $request->input('search');
        $params['status'] = $request->input('status');

        $criteria['status_id'] = $params['status'];
        $criteria['search'] = $params['search'];
        $criteria['company_id'] = $this->user->isAdmin() ? NULL : $this->user->company_id;

        $warehouses = Warehouse::search($criteria, $params['sort'], $params['order'], $params['limit']);

        return view('admin.warehouses.index', [
            'warehouses' => $warehouses,
            'params' => $params,
            'statuses' => WarehouseStatus::all()
        ]);
    }

    /**
     * Show a specific warehouse.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return View
     */
    public function getShow(Request $request, $id)
    {
        $warehouse = Warehouse::findMineOrFail($id);

        return view('admin.warehouses.show', ['warehouse' => $warehouse]);
    }

    /**
     * Show the form for creating a new warehouse.
     *
     * @return View
     */
    public function getCreate()
    {
        return view('admin.warehouses.form', [
            'warehouse'    => new Warehouse,
            'packageTypes' => PackageType::orderBy('name', 'ASC')->get()
        ]);
    }

    /**
     * Create a new warehouse.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function postStore(Request $request)
    {
        $warehouse = new Warehouse;

        $this->validateAndSave($request, $warehouse);

        Flash::success('Warehouse created.');

        return response()->json(['redirect_url' => '/warehouse/' . $warehouse->id]);
    }

    /**
     * Show the form for editing a warehouse.
     *
     * @param  int  $id
     * @return View
     */
    public function getEdit($id)
    {
        $warehouse = Warehouse::findMineOrFail($id);

        return view('admin.warehouses.form', [
            'warehouse'    => $warehouse,
            'packageTypes' => PackageType::orderBy('name', 'ASC')->get()
        ]);
    }

    /**
     * Update a specific warehouse.
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
            return response()->jsonError('Warehouse not found.', 404);
        }

        $this->validateAndSave($request, $warehouse);

        Flash::success('Warehouse updated.');

        return response()->json(['redirect_url' => "/warehouse/{$warehouse->id}/edit"]);
    }

    /**
     * Show the warehouse receipt PDF.
     *
     * @param  Request  $request
     * @param  int      $warehouseId
     * @return void
     */
    public function getPrintReceipt(Request $request, $warehouseId, WarehousePdfService $pdfService)
    {
        $warehouse = Warehouse::findMine($warehouseId);

        if ( ! $warehouse)
        {
            return $this->redirectBackWithError('Warehouse not found.');
        }

        $pdfService->makeReceipt($warehouse);
    }

    /**
     * Show the warehouse shipping label PDF.
     *
     * @param  Request  $request
     * @param  int      $warehouseId
     * @return void
     */
    public function getPrintLabel(Request $request, $warehouseId, WarehousePdfService $pdfService)
    {
        $warehouse = Warehouse::findMine($warehouseId);

        if ( ! $warehouse)
        {
            return $this->redirectBackWithError('Warehouse not found.');
        }

        $pdfService->makeLabel($warehouse);
    }

    /**
     * Prepare and validate the given input and apply it to the given warehouse.
     *
     * @param  Request    $request
     * @param  Warehouse  $warehouse
     * @return void
     * @throws ValidationException
     */
    private function validateAndSave(Request $request, Warehouse $warehouse)
    {

    }
}
