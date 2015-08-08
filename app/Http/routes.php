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
Route::get('accounts/customer/{id}/edit', 'CustomerAccountsController@getEdit')->where('id', '[0-9]+');
Route::post('accounts/customer/{id}/update', 'CustomerAccountsController@postUpdate')->where('id', '[0-9]+');
Route::get('accounts/customer/create', 'CustomerAccountsController@getCreate');
Route::post('accounts/customer/store', 'CustomerAccountsController@postStore');

Route::get('accounts/shippers', 'ShipperAccountsController@getIndex');
Route::get('accounts/shipper/{id}/edit', 'ShipperAccountsController@getEdit')->where('id', '[0-9]+');
Route::post('accounts/shipper/{id}/update', 'ShipperAccountsController@postUpdate')->where('id', '[0-9]+');
Route::get('accounts/shipper/create', 'ShipperAccountsController@getCreate');
Route::post('accounts/shipper/store', 'ShipperAccountsController@postStore');

// Carriers
Route::get('carriers', 'CarriersController@getIndex');
Route::get('carrier/{id}/edit', 'CarriersController@getEdit')->where('id', '[0-9]+');
Route::post('carrier/{id}/update', 'CarriersController@postUpdate')->where('id', '[0-9]+');
Route::get('carrier/create', 'CarriersController@getCreate');
Route::post('carrier/store', 'CarriersController@postStore');
Route::get('carrier/{id}/delete', 'CarriersController@getDelete')->where('id', '[0-9]+');
Route::get('carriers/autocomplete-search', 'CarriersController@getAutocompleteSearch');

// Package types
Route::get('package-types', 'PackageTypesController@getIndex');
Route::get('package-type/{id}/edit', 'PackageTypesController@getEdit')->where('id', '[0-9]+');
Route::post('package-type/{id}/update', 'PackageTypesController@postUpdate')->where('id', '[0-9]+');
Route::get('package-type/create', 'PackageTypesController@getCreate');
Route::post('package-type/store', 'PackageTypesController@postStore');
Route::get('package-type/{id}/delete', 'PackageTypesController@getDelete')->where('id', '[0-9]+');
Route::get('package-types/editable-options', 'PackageTypesController@getEditableOptions');

// Roles
Route::get('roles', 'RolesController@getIndex');

// Companies
Route::get('companies', 'CompaniesController@getIndex');
Route::get('company/{id}/edit', 'CompaniesController@getEdit')->where('id', '[0-9]+');
Route::post('company/{id}/update', 'CompaniesController@postUpdate')->where('id', '[0-9]+');
Route::get('company/create', 'CompaniesController@getCreate');
Route::post('company/store', 'CompaniesController@postStore');

// Packages
Route::get('packages', 'PackagesController@getIndex');
Route::get('package/{id}/details', 'PackagesController@getPackageDetails')->where('id', '[0-9]+');
Route::post('package/{id}/editable-field', 'PackagesController@postEditableField')->where('id', '[0-9]+');
Route::get('customer/package/{id}/details', 'PackagesController@getCustomerPackageDetails')->where('id', '[0-9]+');

// Warehouses
Route::get('warehouses', 'WarehousesController@getIndex');
Route::get('warehouse/{id}', 'WarehousesController@getShow')->where('id', '[0-9]+');
Route::get('warehouse/{id}/edit', 'WarehousesController@getEdit')->where('id', '[0-9]+');
Route::post('warehouse/{id}/update', 'WarehousesController@postUpdate')->where('id', '[0-9]+');
Route::get('warehouse/{id}/print-receipt', 'WarehousesController@getPrintReceipt')->where('id', '[0-9]+');
Route::get('warehouse/{id}/print-label', 'WarehousesController@getPrintLabel')->where('id', '[0-9]+');
Route::get('warehouse/create', 'WarehousesController@getCreate');
Route::post('warehouse/store', 'WarehousesController@postStore');
Route::get('warehouse/{id}/packages', 'PackagesController@getWarehousePackages')->where('id', '[0-9]+');

// Shipments
Route::get('shipments', 'ShipmentsController@getIndex');
Route::get('shipment/{id}', 'ShipmentsController@getShow')->where('id', '[0-9]+')->where('id', '[0-9]+');
Route::get('shipment/{id}/edit', 'ShipmentsController@getEdit')->where('id', '[0-9]+')->where('id', '[0-9]+');
Route::post('shipment/{id}/update', 'ShipmentsController@postUpdate')->where('id', '[0-9]+')->where('id', '[0-9]+');
Route::get('shipment/create', 'ShipmentsController@getCreate');
Route::post('shipment/store', 'ShipmentsController@postStore');
Route::get('shipment/{id}/packages', 'PackagesController@getShipmentPackages')->where('id', '[0-9]+');

// Users
Route::get('users', 'UsersController@getIndex');
Route::get('user/{id}/edit', 'UsersController@getEdit')->where('id', '[0-9]+');
Route::post('user/{id}/update', 'UsersController@postUpdate')->where('id', '[0-9]+');
Route::get('user/create', 'UsersController@getCreate');
Route::post('user/store', 'UsersController@postStore');

// User Profile
Route::get('user/profile', ['uses' => 'UserProfileController@getProfile']);
Route::get('user/profile/edit', 'UserProfileController@getEditProfile');
Route::post('user/profile', 'UserProfileController@postProfile');
Route::get('user/change-password', 'UserProfileController@getChangePassword');
Route::post('user/change-password', 'UserProfileController@postChangePassword');
Route::post('user/upload-photo', 'UserProfileController@postUploadPhoto');
Route::post('customer/profile', 'UserProfileController@postCustomerProfile');

// Company Profile
Route::get('company/profile', 'CompanyProfileController@getProfile');
Route::get('company/profile/edit', 'CompanyProfileController@getEditProfile');
Route::post('company/profile', 'CompanyProfileController@postProfile');
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
Route::get('activate', 'AuthController@getActivateAccount');

Route::get('/', 'AuthController@getLogin');
Route::get('home', 'AuthController@getLogin');

