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
        DB::table('warehouse_statuses')->delete();

        DB::table('warehouse_statuses')->insert([
            ['name' => 'Unprocessed'],
            ['name' => 'Pending'],
            ['name' => 'Complete'],
        ]);
    }
}
