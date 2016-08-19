<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CountriesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');

        DB::table('countries')->delete();

        DB::table('countries')->insert([
            ['name' => 'United States', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Colombia', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ]);
    }
}
