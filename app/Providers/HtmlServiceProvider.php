<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;

/**
 * HtmlServiceProvider
 *
 * @author Victor Lantigua <vmlantigua@gmail.com>
 */
class HtmlServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        App::bind('html', function() {
            return new \App\Helpers\Html;
        });
    }
}
