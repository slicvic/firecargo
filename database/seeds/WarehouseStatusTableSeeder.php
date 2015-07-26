<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class WarehouseStatusSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warehouse_statuses')->truncate();

        DB::table('warehouse_statuses')->insert([
            ['name' => 'new'],
            ['name' => 'pending'],
            ['name' => 'complete'],
        ]);
    }
}
