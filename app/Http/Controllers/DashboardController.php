<?php namespace App\Http\Controllers;

class DashboardController extends BaseAuthController {

    public function anyIndex()
    {
        return $this->getPageView('dashboard');
    }
}
