<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AccountTypeTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_types')->truncate();

        DB::table('account_types')->insert([
            ['name' => 'Client'],
            ['name' => 'Consignee'],
            ['name' => 'Shipper'],
        ]);
    }
}
