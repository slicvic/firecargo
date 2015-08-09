<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AccountTagsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_tags')->delete();

        DB::table('account_tags')->insert([
            ['name' => 'Customer'],
            ['name' => 'Shipper'],
        ]);
    }
}
