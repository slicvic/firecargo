<?php namespace App\Http\Controllers;

use \App\Models\User;
use Auth;

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
