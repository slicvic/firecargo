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
        $createdAt = date('Y-m-d H:i:s');

        DB::table('countries')->delete();

        DB::table('countries')->insert([
            ['name' => 'United States', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Colombia', 'created_at' => $createdAt, 'updated_at' => $createdAt],
        ]);
    }
}
