<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CountryTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('countries')->truncate();

        DB::table('countries')->insert([
            ['name' => 'United States'],
            ['name' => 'Colombia'],
        ]);
    }
}
