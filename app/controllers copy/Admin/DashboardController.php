<?php

class AdminDashboardController extends AdminBaseController {

    protected $layout = 'admin.layouts.default';

    /**
     * Dashboard page.
     */
    public function getDashboard()
    {
        $this->layout->content = View::make('admin.dashboard');
    }
}
