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

		$this->call('PackageTypeTableSeeder');
		$this->command->info('Package type table seeded!');

		$this->call('RoleTableSeeder');
		$this->command->info('Role table seeded!');

		$this->call('WarehouseStatusTableSeeder');
		$this->command->info('Warehouse status table seeded!');

		$this->call('AccountTypeTableSeeder');
		$this->command->info('Account type table seeded!');

		$this->call('CountryTableSeeder');
		$this->command->info('Country table seeded!');

		$this->call('CarrierTableSeeder');
		$this->command->info('Carrier table seeded!');

	}

}
