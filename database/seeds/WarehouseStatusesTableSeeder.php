<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class WarehouseStatusesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');

        DB::table('warehouse_statuses')->delete();

        DB::table('warehouse_statuses')->insert([
            ['name' => 'Unprocessed', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Pending', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Complete', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ]);
    }
}
