<?php

namespace App\Http\Controllers\Admin;

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
class DashboardController extends BaseAdminController {

    /**
     * Show the dashboard.
     *
     * @return View
     */
    public function getIndex()
    {
        if ($this->user->isCustomer())
        {
            return $this->showCustomerDashboard();
        }
        elseif ($this->user->isAgent())
        {
            return $this->showAgentDashboard();
        }
        else
        {
            return $this->showAdminDashboard();
        }
    }

    /**
     * Render customer dashboard.
     *
     * @return View
     */
    private function showCustomerDashboard()
    {
        $criteria['customer_account_id'] = $this->user->account->id;

        $packages = Package::search($criteria, 'id', 'desc', 100);

        return view('admin.dashboard.customers.index', ['packages' => $packages]);
    }

    /**
     * Render agent dashboard.
     *
     * @return View
     */
    private function showAgentDashboard()
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

        return view('admin.dashboard.admins.index', ['totals' => $totals]);
    }

    /**
     * Render admin dashboard.
     *
     * @return View
     */
    private function showAdminDashboard()
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

        return view('admin.dashboard.admins.index', ['totals' => $totals]);
    }
}
