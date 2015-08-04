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

/**
 * -------------------------------------------------
 * Admin
 * -------------------------------------------------
 */

// Accounts
Route::get('accounts/autocomplete-search', 'AccountsController@getAutocompleteSearch');

// Carriers
Route::get('carriers', 'CarriersController@getIndex');
Route::get('carrier/{id}/edit', 'CarriersController@getEdit');
Route::post('carrier/{id}/update', 'CarriersController@postUpdate');
Route::get('carrier/create', 'CarriersController@getCreate');
Route::post('carrier/store', 'CarriersController@postStore');
Route::get('carrier/{id}/delete', 'CarriersController@getDelete');
Route::get('carriers/autocomplete-search', 'CarriersController@getAutocompleteSearch');

// Package types
Route::get('package-types', 'PackageTypesController@getIndex');
Route::get('package-type/{id}/edit', 'PackageTypesController@getEdit');
Route::post('package-type/{id}/update', 'PackageTypesController@postUpdate');
Route::get('package-type/create', 'PackageTypesController@getCreate');
Route::post('package-type/store', 'PackageTypesController@postStore');
Route::get('package-type/{id}/delete', 'PackageTypesController@getDelete');
Route::get('package-types/editable-options', 'PackageTypesController@getEditableOptions');

// Sites
Route::get('sites', 'SitesController@getIndex');
Route::get('site/{id}/edit', 'SitesController@getEdit');
Route::post('site/{id}/update', 'SitesController@postUpdate');
Route::get('site/create', 'SitesController@getCreate');
Route::post('site/store', 'SitesController@postStore');

// Roles
Route::get('roles', 'RolesController@getIndex');

// Sites
Route::get('customers', 'CustomerAccountsController@getIndex');
Route::get('customer/{id}/edit', 'CustomerAccountsController@getEdit');
Route::post('customer/{id}/update', 'CustomerAccountsController@postUpdate');
Route::get('customer/create', 'CustomerAccountsController@getCreate');
Route::post('customer/store', 'CustomerAccountsController@postStore');

// Sites
Route::get('shippers', 'ShipperAccountsController@getIndex');
Route::get('shipper/{id}/edit', 'ShipperAccountsController@getEdit');
Route::post('shipper/{id}/update', 'ShipperAccountsController@postUpdate');
Route::get('shipper/create', 'ShipperAccountsController@getCreate');
Route::post('shipper/store', 'ShipperAccountsController@postStore');

// Companies
Route::get('companies', 'CompaniesController@getIndex');
Route::get('company/{id}/edit', 'CompaniesController@getEdit');
Route::post('company/{id}/update', 'CompaniesController@postUpdate');
Route::get('company/create', 'CompaniesController@getCreate');
Route::post('company/store', 'CompaniesController@postStore');

// Companies
Route::get('companies', 'CompaniesController@getIndex');
Route::get('company/{id}/edit', 'CompaniesController@getEdit');
Route::post('company/{id}/update', 'CompaniesController@postUpdate');
Route::get('company/create', 'CompaniesController@getCreate');
Route::post('company/store', 'CompaniesController@postStore');

// Users
Route::get('users', 'UsersController@getIndex');
Route::get('user/{id}/edit', 'UsersController@getEdit');
Route::post('user/{id}/update', 'UsersController@postUpdate');
Route::get('user/create', 'UsersController@getCreate');
Route::post('user/store', 'UsersController@postStore');

// Packages
Route::get('packages', 'PackagesController@getIndex');
Route::get('package/{id}/details', 'PackagesController@getDetails');
Route::post('package/{id}/editable-field', 'PackagesController@postEditableField');

// Warehouses
Route::get('warehouses', 'WarehousesController@getIndex');
Route::get('warehouse/{id}/show', 'WarehousesController@getShow');
Route::get('warehouse/{id}/edit', 'WarehousesController@getEdit');
Route::post('warehouse/{id}/update', 'WarehousesController@postUpdate');
Route::get('warehouse/{id}/print-receipt', 'WarehousesController@getPrintReceipt');
Route::get('warehouse/{id}/print-label', 'WarehousesController@getPrintLabel');
Route::get('warehouse/create', 'WarehousesController@getCreate');
Route::post('warehouse/store', 'WarehousesController@postStore');
Route::get('warehouse/{id}/packages', 'PackagesController@getWarehousePackages');

// Shipments
Route::get('shipments', 'ShipmentsController@getIndex');
Route::get('shipment/{id}/show', 'ShipmentsController@getShow');
Route::get('shipment/{id}/edit', 'ShipmentsController@getEdit');
Route::post('shipment/{id}/update', 'ShipmentsController@postUpdate');
Route::get('shipment/create', 'ShipmentsController@getCreate');
Route::post('shipment/store', 'ShipmentsController@postStore');
Route::get('shipment/{id}/packages', 'PackagesController@getShipmentPackages');

// User Profile
Route::get('logout', 'UserProfileController@getLogout');
Route::get('user/profile', 'UserProfileController@getProfile');
Route::get('user/edit', 'UserProfileController@getEdit');
Route::post('user/profile', 'UserProfileController@postProfile');
Route::post('customer/profile', 'UserProfileController@postCustomerProfile');
Route::get('user/password', 'UserProfileController@getPassword');
Route::post('user/password', 'UserProfileController@postPassword');
Route::post('user/photo', 'UserProfileController@postPhoto');

// Company Profile
Route::controller('company', 'CompanyProfileController');

// Dashboard
Route::controller('dashboard', 'DashboardController');

/**
 * -------------------------------------------------
 * Frontend
 * -------------------------------------------------
 */

// Auth
Route::get('login', 'AuthController@getLogin');
Route::post('login', 'AuthController@postLogin');

// Frontend
Route::get('register', 'AuthController@getRegister');
Route::post('register', 'AuthController@postRegister');
Route::get('forgot-password', 'AuthController@getForgotPassword');
Route::post('forgot-password', 'AuthController@postForgotPassword');
Route::get('reset-password', 'AuthController@getResetPassword');
Route::post('reset-password', 'AuthController@postResetPassword');

Route::get('/', 'AuthController@getLogin');
Route::get('home', 'AuthController@getLogin');

