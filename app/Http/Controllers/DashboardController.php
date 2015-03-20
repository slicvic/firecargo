<?php namespace App\Http\Controllers;

class DashboardController extends BaseAuthController {

    public function getIndex()
    {
        return view('dashboard.index');
    }
}
