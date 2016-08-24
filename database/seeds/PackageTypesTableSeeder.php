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
        $timestamp = date('Y-m-d H:i:s');

        DB::table('package_types')->delete();

        DB::table('package_types')->insert([
            ['name' => 'Box', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Piece', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Bundle', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Carton', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Roll', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Crate', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Pallet', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Drum', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Tube', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Envolope', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ]);
    }
}
