<?php namespace App\Http\Controllers;

class DashboardController extends BaseAuthController {

    public function getIndex()
    {

        if ($this->user->isAdmin())
        {
            // TODO
            return view('dashboard.admins.index');
        }
        elseif ($this->user->isAgent())
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
