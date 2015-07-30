<?php namespace App\Http\Controllers;

use Auth;

use App\Models\User;
use App\Pdf\WarehousePdf;
use App\Models\Warehouse;
use App\Models\WarehouseStatus;
use App\Models\Package;

/**
 * DashboardController
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class DashboardController extends BaseAuthController {

    /**
     * Shows the dashboard.
     *
     * @return Response
     */
    public function getIndex()
    {
        if ($this->authUser->isClient())
        {
            $criteria['client_account_id'] = $this->authUser->client->id;
            $packages = Package::search($criteria);

            return view('dashboard.clients.index', ['packages' => $packages]);
        }
        else
        {
            $totals = [
                'unprocessed' => Warehouse::countByStatusIdAndCompanyId(WarehouseStatus::UNPROCESSED, $this->authUser->company_id),
                'pending' => Warehouse::countByStatusIdAndCompanyId(WarehouseStatus::PENDING, $this->authUser->company_id),
                'complete' => Warehouse::countByStatusIdAndCompanyId(WarehouseStatus::COMPLETE, $this->authUser->company_id)
            ];

            return view('dashboard.index', ['totals' => $totals]);
        }
    }
}
