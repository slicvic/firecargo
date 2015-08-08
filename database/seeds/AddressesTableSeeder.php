<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AddressesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('addresses')->delete();

        DB::table('addresses')->insert([
            [
                'id' => 1
            ],
            [
                'id' => 2
            ]
        ]);
    }
}
