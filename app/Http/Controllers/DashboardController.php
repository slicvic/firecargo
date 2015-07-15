<?php namespace App\Http\Controllers;

use Auth;

use App\Models\User;
use App\Pdf\Warehouse as WarehousePdf;

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
        if ($this->authUser->isAdmin())
        {
            // TODO
            return view('dashboard.admins.index');
        }
        elseif ($this->authUser->isAgent())
        {
            // TODO
            return view('dashboard.agents.index');
        }
        else
        {
            return view('dashboard.clients.index');
        }
    }
}
