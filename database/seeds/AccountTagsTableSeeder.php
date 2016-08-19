<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AccountTagsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createdAt = date('Y-m-d H:i:s');

        DB::table('account_tags')->delete();

        DB::table('account_tags')->insert([
            ['name' => 'Customer', 'created_at' => $createdAt, 'updated_at' => $createdAt],
            ['name' => 'Shipper', 'created_at' => $createdAt, 'updated_at' => $createdAt],
        ]);
    }
}
