<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * FlashServiceProvider
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class FlashServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('flash', function($app) {
            return $this->app->make('App\Session\FlashNotifier');
        });
    }
}
