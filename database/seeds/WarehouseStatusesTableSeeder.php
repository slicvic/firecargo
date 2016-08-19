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
        $createdAt = date('Y-m-d H:i:s');

        DB::table('warehouse_statuses')->delete();

        DB::table('warehouse_statuses')->insert([
            ['name' => 'Unprocessed', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Pending', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Complete', 'created_at' => $createdAt, 'updated_at' => $createdAt],
        ]);
    }
}
