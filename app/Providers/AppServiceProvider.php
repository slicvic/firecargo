<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use App;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
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
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
        App::bind('flash', function() {
            return new \App\Session\Flash;
        });

        App::bind('html', function() {
            return new \App\Helpers\Html;
        });
    }
}
