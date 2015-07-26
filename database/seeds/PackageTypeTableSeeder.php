<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PackageTypeTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('package_types')->truncate();

        DB::table('package_types')->insert([
            ['name' => 'Box'],
            ['name' => 'Piece'],
            ['name' => 'Bundle'],
            ['name' => 'Carton'],
            ['name' => 'Roll'],
            ['name' => 'Crate'],
            ['name' => 'Pallet'],
            ['name' => 'Drum'],
            ['name' => 'Tube'],
            ['name' => 'Envolope'],
        ]);
    }
}
