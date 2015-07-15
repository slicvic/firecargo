<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

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
        App::bind('flash', function() {
            return new \App\Session\Flash;
        });
    }
}
