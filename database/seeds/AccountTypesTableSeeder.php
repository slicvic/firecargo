<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AccountTypesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_types')->delete();

        DB::table('account_types')->insert([
            ['name' => 'Customer'],
            ['name' => 'Shipper'],
        ]);
    }
}
