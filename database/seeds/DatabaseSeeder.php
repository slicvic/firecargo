<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('AddressesTableSeeder');
		$this->command->info('Addresses table seeded!');

		$this->call('PackageTypesTableSeeder');
		$this->command->info('Package types table seeded!');

		$this->call('RolesTableSeeder');
		$this->command->info('Role table seeded!');

		$this->call('WarehouseStatusesTableSeeder');
		$this->command->info('Warehouse status table seeded!');

		$this->call('AccountTypesTableSeeder');
		$this->command->info('Account type table seeded!');

		$this->call('CountriesTableSeeder');
		$this->command->info('Country table seeded!');

		$this->call('CarriersTableSeeder');
		$this->command->info('Carrier table seeded!');

		$this->call('CompaniesTableSeeder');
		$this->command->info('Company table seeded!');

		$this->call('UsersTableSeeder');
		$this->command->info('Users table seeded!');
	}
}
