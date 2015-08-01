<?php namespace App\Http\Controllers;

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
        if ($this->user->isClient())
        {
            return $this->renderClientDashboard();
        }
        elseif ($this->user->isAgent())
        {
            return $this->renderAgentDashboard();
        }
        else
        {
            return $this->renderAdminDashboard();
        }
    }

    private function renderClientDashboard()
    {
        $criteria['client_account_id'] = $this->user->client->id;
        $packages = Package::search($criteria);

        return view('dashboard.client.index', ['packages' => $packages]);
    }

    private function renderAgentDashboard()
    {
        $totals = [
            'warehouses' => [
                'unprocessed' => Warehouse::mine()->unprocessed()->count(),
                'pending' => Warehouse::mine()->pending()->count(),
                'complete' => Warehouse::mine()->complete()->count()
            ],
            'packages' => [
                'unprocessed' => Package::mine()->unprocessed()->count(),
                'hold' => Package::mine()->onHold()->count(),
                'shipped' => Package::mine()->shipped()->count()
            ]
        ];

        return view('dashboard.index', ['totals' => $totals]);
    }

    private function renderAdminDashboard()
    {
        $totals = [
            'warehouses' => [
                'unprocessed' => Warehouse::unprocessed()->count(),
                'pending' => Warehouse::pending()->count(),
                'complete' => Warehouse::complete()->count()
            ],
            'packages' => [
                'unprocessed' => Package::unprocessed()->count(),
                'hold' => Package::onHold()->count(),
                'shipped' => Package::shipped()->count()
            ]
        ];

        return view('dashboard.index', ['totals' => $totals]);
    }
}
