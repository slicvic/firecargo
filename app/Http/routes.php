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
Route::controller('couriers', 'CouriersController');
Route::controller('package-statuses', 'PackageStatusesController');
Route::controller('package-types', 'PackageTypesController');
Route::controller('packages', 'PackagesController');
Route::controller('sites', 'SitesController');
Route::controller('companies', 'CompaniesController');
Route::controller('roles', 'RolesController');
Route::controller('accounts', 'UsersController');
Route::controller('warehouses', 'WarehousesController');
Route::controller('company', 'CompanyController');

Route::controller('account', 'AccountController');
Route::get('logout', 'AccountController@getLogout');

// Guests
Route::get('login', 'AuthController@getLogin');
Route::post('login', 'AuthController@postLogin');

Route::get('signup', 'AuthController@getSignup');
Route::post('signup', 'AuthController@postSignup');
Route::get('forgot-password', 'AuthController@getForgotPassword');
Route::post('forgot-password', 'AuthController@postForgotPassword');
Route::get('reset-password', 'AuthController@getResetPassword');
Route::post('reset-password', 'AuthController@postResetPassword');

Route::get('/', 'AuthController@getLogin');
Route::get('home', 'AuthController@getLogin');

