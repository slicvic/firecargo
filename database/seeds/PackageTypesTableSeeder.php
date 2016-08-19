<?php

use Illuminate\Database\Seeder;

class PackageTypesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createdAt = date('Y-m-d H:i:s');

        DB::table('package_types')->delete();

        DB::table('package_types')->insert([
            ['name' => 'Box', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Piece', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Bundle', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Carton', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Roll', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Crate', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Pallet', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Drum', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Tube', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Envolope', 'created_at' => $createdAt, 'updated_at' => $createdAt],
        ]);
    }
}
