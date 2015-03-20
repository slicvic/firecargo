<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Member
Route::controller('dashboard', 'DashboardController');
Route::controller('accounts', 'UsersController');
Route::controller('companies', 'CompaniesController');
Route::controller('roles', 'RolesController');
Route::controller('statuses', 'WarehouseStatusesController');
Route::controller('carriers', 'ShippingCarriersController');
Route::controller('warehouses', 'WarehousesController');

Route::controller('account', 'AccountController');
Route::get('logout', 'AccountController@getLogout');

// Guests
Route::get('login', 'GuestsController@getLogin');
Route::post('login', 'GuestsController@postLogin');

Route::get('signup', 'GuestsController@getSignup');
Route::post('signup', 'GuestsController@postSignup');
Route::get('forgot-password', 'GuestsController@getForgotPassword');
Route::post('forgot-password', 'GuestsController@postForgotPassword');
Route::get('reset-password', 'GuestsController@getResetPassword');
Route::post('reset-password', 'GuestsController@postResetPassword');

Route::get('/', 'GuestsController@getLogin');
Route::get('home', 'GuestsController@getLogin');

