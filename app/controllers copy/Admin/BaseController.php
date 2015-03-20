<?php

class AdminBaseController extends BaseController {

    protected $layout = 'admin.layouts.default';

    public function __construct()
    {
        App::setLocale('en');

        $this->beforeFilter('auth', ['except' => []]);

        $this->beforeFilter(function() {
            if (Auth::check() && ! Auth::user()->isAdmin()) {;
                return Redirect::to('/');
            }
        });
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }
}
