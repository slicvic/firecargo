<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create companies
		Schema::create('companies', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->string('name', 50);
		    $table->string('corp_code', 10);
		    $table->string('phone', 30);
		    $table->string('fax', 30);
		    $table->string('email', 255);
		    $table->tinyInteger('has_logo')->unsigned();
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');
		});

		// Create sites
		Schema::create('sites', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->integer('company_id')->unsigned();
		    $table->string('name', 100);
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');

		    $table->foreign('company_id')->references('id')->on('companies');
		});

		// Create roles
		Schema::create('roles', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->string('name', 30);
		    $table->string('description', 255);
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');
		});

		// Create users
		Schema::create('users', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->integer('company_id')->unsigned();
		    $table->integer('role_id')->unsigned();
		    $table->string('firstname', 50);
		    $table->string('lastname', 50);
		    $table->string('email', 255)->unique('email');
		    $table->string('password', 255);
		    $table->tinyInteger('has_photo')->unsigned();
		    $table->tinyInteger('active')->unsigned();
		    $table->string('remember_token', 255);
		    $table->integer('logins')->unsigned();
		    $table->dateTime('last_login');
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');

		    $table->foreign('company_id')->references('id')->on('companies');
		    $table->foreign('role_id')->references('id')->on('roles');
		});

		// Create account_types
		Schema::create('account_types', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->string('name', 30);
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');
		});

		// Create accounts
		Schema::create('accounts', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->integer('company_id')->unsigned();
		    $table->integer('type_id')->unsigned();
		    $table->integer('user_id')->unsigned()->nullable();
		    $table->string('name', 100);
		    $table->string('firstname', 50);
		    $table->string('lastname', 50);
		    $table->string('email', 255);
		    $table->string('phone', 30);
		    $table->string('mobile_phone', 30);
		    $table->string('fax', 30);
		    $table->tinyInteger('autoship')->unsigned();
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');

		    $table->foreign('company_id')->references('id')->on('companies');
		    $table->foreign('type_id')->references('id')->on('account_types');
		    $table->foreign('user_id')->references('id')->on('users');
		});

		// Create countries
		Schema::create('countries', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->string('name', 100);

		});

		// Create addresses
		Schema::create('addresses', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->integer('account_id')->unsigned()->nullable();
		    $table->integer('company_id')->unsigned()->nullable();
		    $table->string('address1', 255);
		    $table->string('address2', 255);
		    $table->string('city', 30);
		    $table->string('state', 30);
		    $table->string('postal_code', 10);
		    $table->integer('country_id')->unsigned()->nullable();
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');

		    $table->foreign('company_id')->references('id')->on('companies');
		    $table->foreign('account_i')->references('id')->on('accounts');
		    $table->foreign('country_id')->references('id')->on('countries');
		});

		// Create carriers
		Schema::create('carriers', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->string('name', 100);
		    $table->string('code', 10);
		    $table->string('prefix', 10);
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');
		});

		// Create log_user_actions
		Schema::create('log_user_actions', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->integer('user_id')->unsigned();
			$table->enum('action', ['create', 'read', 'update', 'delete']);
		    $table->string('table_name', 100);
		    $table->integer('record_id')->unsigned();
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');
		});

		// Create shipments
		Schema::create('shipments', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->integer('company_id')->unsigned();
		    $table->integer('carrier_id')->unsigned();
		    $table->string('reference_number', 255);
		    $table->dateTime('departed_at');
		    $table->integer('creator_user_id')->unsigned();
		    $table->integer('updater_user_id')->unsigned()->nullable();
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');

		    $table->foreign('company_id')->references('id')->on('companies');
		    $table->foreign('carrier_id')->references('id')->on('carriers');
		    $table->foreign('creator_user_id')->references('id')->on('users');
		    $table->foreign('updater_user_id')->references('id')->on('users');
		});

		// Create warehouse_statuses
		Schema::create('warehouse_statuses', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->string('name', 30);
		});

		// Create warehouses
		Schema::create('warehouses', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->integer('company_id')->unsigned();
		    $table->integer('status_id')->unsigned();
		    $table->integer('shipper_account_id')->unsigned();
		    $table->integer('consignee_account_id')->unsigned();
		    $table->integer('carrier_id')->unsigned();
		    $table->string('notes', 1000);
		    $table->dateTime('arrived_at');
		    $table->integer('creator_user_id')->unsigned();
		    $table->integer('updater_user_id')->unsigned()->nullable();
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');

		    $table->foreign('company_id')->references('id')->on('companies');
		    $table->foreign('status_id')->references('id')->on('warehouse_statuses');
		    $table->foreign('shipper_account_id')->references('id')->on('accounts');
		    $table->foreign('consignee_account_id')->references('id')->on('accounts');
		    $table->foreign('carrier_id')->references('id')->on('carriers');
		    $table->foreign('creator_user_id')->references('id')->on('users');
		    $table->foreign('updater_user_id')->references('id')->on('users');
		});

		// Create package_types
		Schema::create('package_types', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->string('name', 30);
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');
		});

		// Create package_statuses
		Schema::create('package_statuses', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->integer('company_id')->unsigned();
		    $table->tinyInteger('default')->unsigned();
		    $table->string('name', 100);
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');

		    $table->foreign('company_id')->references('id')->on('companies');
		});

		// Create packages
		Schema::create('packages', function($table)
		{
		    $table->increments('id')->unsigned();
		    $table->integer('company_id')->unsigned();
		    $table->integer('warehouse_id')->unsigned();
		    $table->integer('shipment_id')->unsigned()->nullable();
		    $table->integer('status_id')->unsigned();
		    $table->integer('type_id')->unsigned();
		    $table->float('length')->unsigned();
		    $table->float('width')->unsigned();
		    $table->float('height')->unsigned();
		    $table->string('description', 255);
		    $table->string('invoice_number', 255);
		    $table->decimal('invoice_amount', 12, 4)->unsigned();
		    $table->string('tracking_number', 255);
		    $table->tinyInteger('ship')->unsigned();
		    $table->dateTime('created_at');
		    $table->dateTime('updated_at');
		    $table->dateTime('deleted_at');

		    $table->foreign('company_id')->references('id')->on('companies');
		    $table->foreign('warehouse_id')->references('id')->on('warehouses');
		    $table->foreign('shipment_id')->references('id')->on('shipments');
		    $table->foreign('status_id')->references('id')->on('package_statuses');
		    $table->foreign('type_id')->references('id')->on('package_types');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('companies');
		Schema::drop('sites');

		Schema::drop('packages');
		Schema::drop('package_types');
		Schema::drop('package_statuses');

		Schema::drop('warehouses');
		Schema::drop('warehouse_statuses');

		Schema::drop('shipments');

		Schema::drop('users');
		Schema::drop('roles');

		Schema::drop('accounts');
		Schema::drop('account_types');

		Schema::drop('countries');
		Schema::drop('addresses');
		Schema::drop('carriers');
		Schema::drop('log_user_actions');

	}
}
