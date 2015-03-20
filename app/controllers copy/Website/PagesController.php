<?php

class WebsitePagesController extends BaseController {

    protected $layout = 'website.layouts.default';

    /**
     * Home page.
     */
    public function getHome()
    {
        $this->layout->content = View::make('website.home');
    }
}
