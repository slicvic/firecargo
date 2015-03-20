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
Route::controller('users', 'UsersController');
Route::controller('companies', 'CompaniesController');
Route::controller('roles', 'RolesController');
Route::controller('ws', 'WarehouseStatusesController');
Route::controller('carriers', 'ShippingCarriersController');

Route::get('logout', 'UsersController@getLogout');

// Guests
Route::any('login', 'GuestsController@anyLogin');
Route::any('signup', 'GuestsController@anySignup');
Route::any('forgot-password', 'GuestsController@anyForgotPassword');
Route::any('reset-password', 'GuestsController@anyResetPassword');

Route::get('/', 'GuestsController@anyLogin');
Route::get('home', 'GuestsController@anyLogin');

