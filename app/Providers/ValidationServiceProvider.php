<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class ValidationServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('alpha_spaces', function($attribute, $value, $parameters) {
            return (bool) preg_match('/^[A-Za-z\s]+$/', $value);
        });

        Validator::extend('alpha_num_spaces', function($attribute, $value, $parameters) {
            return (bool) preg_match( "/^[A-Za-z0-9\s]+$/", $value );
        });

        Validator::extend('phone', function($attribute, $value, $parameters) {
            return (bool) preg_match('/^([0-9\s\-\+\(\)]*)$/', $value);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
