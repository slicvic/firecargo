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
            return $this->renderClientDashboard();
        }
        else
        {
            return $this->renderAgentAdminDashboard();
        }
    }

    private function renderClientDashboard()
    {
        $criteria['client_account_id'] = $this->authUser->client->id;
        $packages = Package::search($criteria);

        return view('dashboard.client.index', ['packages' => $packages]);
    }

    private function renderAgentAdminDashboard()
    {
        $totals = [
            'warehouses' => [
                'unprocessed' => Warehouse::countByStatusIdAndCompanyId(WarehouseStatus::UNPROCESSED, $this->authUser->company_id),
                'pending' => Warehouse::countByStatusIdAndCompanyId(WarehouseStatus::PENDING, $this->authUser->company_id),
                'complete' => Warehouse::countByStatusIdAndCompanyId(WarehouseStatus::COMPLETE, $this->authUser->company_id)
            ],
            'packages' => [
                'shipped' => Package::countShippedByCompanyId($this->authUser->company_id),
                'pending' => Package::countNotShippedByCompanyId($this->authUser->company_id)
            ]
        ];

        return view('dashboard.index', ['totals' => $totals]);
    }
}
