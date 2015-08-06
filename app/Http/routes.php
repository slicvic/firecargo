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

Route::get('accounts/customers', 'CustomerAccountsController@getIndex');
Route::get('accounts/customer/{id}/edit', 'CustomerAccountsController@getEdit');
Route::post('accounts/customer/{id}/update', 'CustomerAccountsController@postUpdate');
Route::get('accounts/customer/create', 'CustomerAccountsController@getCreate');
Route::post('accounts/customer/store', 'CustomerAccountsController@postStore');

Route::get('accounts/shippers', 'ShipperAccountsController@getIndex');
Route::get('accounts/shipper/{id}/edit', 'ShipperAccountsController@getEdit');
Route::post('accounts/shipper/{id}/update', 'ShipperAccountsController@postUpdate');
Route::get('accounts/shipper/create', 'ShipperAccountsController@getCreate');
Route::post('accounts/shipper/store', 'ShipperAccountsController@postStore');

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

// Roles
Route::get('roles', 'RolesController@getIndex');

// Companies
Route::get('companies', 'CompaniesController@getIndex');
Route::get('company/{id}/edit', 'CompaniesController@getEdit');
Route::post('company/{id}/update', 'CompaniesController@postUpdate');
Route::get('company/create', 'CompaniesController@getCreate');
Route::post('company/store', 'CompaniesController@postStore');

// Packages
Route::get('packages', 'PackagesController@getIndex');
Route::get('package/{id}/details', 'PackagesController@getPackageDetails');
Route::post('package/{id}/editable-field', 'PackagesController@postEditableField');
Route::get('customer/package/{id}/details', 'PackagesController@getCustomerPackageDetails');

// Warehouses
Route::get('warehouses', 'WarehousesController@getIndex');
Route::get('warehouse/{id}', 'WarehousesController@getShow');
Route::get('warehouse/{id}/edit', 'WarehousesController@getEdit');
Route::post('warehouse/{id}/update', 'WarehousesController@postUpdate');
Route::get('warehouse/{id}/print-receipt', 'WarehousesController@getPrintReceipt');
Route::get('warehouse/{id}/print-label', 'WarehousesController@getPrintLabel');
Route::get('warehouse/create', 'WarehousesController@getCreate');
Route::post('warehouse/store', 'WarehousesController@postStore');
Route::get('warehouse/{id}/packages', 'PackagesController@getWarehousePackages');

// Shipments
Route::get('shipments', 'ShipmentsController@getIndex');
Route::get('shipment/{id}', 'ShipmentsController@getShow');
Route::get('shipment/{id}/edit', 'ShipmentsController@getEdit');
Route::post('shipment/{id}/update', 'ShipmentsController@postUpdate');
Route::get('shipment/create', 'ShipmentsController@getCreate');
Route::post('shipment/store', 'ShipmentsController@postStore');
Route::get('shipment/{id}/packages', 'PackagesController@getShipmentPackages');

// Users
Route::get('users', 'UsersController@getIndex');
Route::get('user/{id}/edit', 'UsersController@getEdit');
Route::post('user/{id}/update', 'UsersController@postUpdate');
Route::get('user/create', 'UsersController@getCreate');
Route::post('user/store', 'UsersController@postStore');

// User Profile
Route::get('user/profile', ['uses' => 'UserProfileController@getProfile']);
Route::get('user/edit-profile', 'UserProfileController@getEditProfile');
Route::post('user/profile', 'UserProfileController@postUpdateProfile');
Route::get('user/change-password', 'UserProfileController@getChangePassword');
Route::post('user/change-password', 'UserProfileController@postChangePassword');
Route::post('user/upload-photo', 'UserProfileController@postUploadPhoto');
Route::post('customer/user/profile', 'UserProfileController@postUpdateCustomerProfile');

// Company Profile
Route::get('company/profile', 'CompanyProfileController@getProfile');
Route::get('company/edit-profile', 'CompanyProfileController@getEditProfile');
Route::post('company/profile', 'CompanyProfileController@postUpdateProfile');
Route::post('company/upload-logo', 'CompanyProfileController@postUploadLogo');

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
Route::get('logout', 'AuthController@getLogout');
Route::get('register', 'AuthController@getRegister');
Route::post('register', 'AuthController@postRegister');
Route::get('forgot-password', 'AuthController@getForgotPassword');
Route::post('forgot-password', 'AuthController@postForgotPassword');
Route::get('reset-password', 'AuthController@getResetPassword');
Route::post('reset-password', 'AuthController@postResetPassword');

Route::get('/', 'AuthController@getLogin');
Route::get('home', 'AuthController@getLogin');

