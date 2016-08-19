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
        $timestamp = date('Y-m-d H:i:s');

        DB::table('account_tags')->delete();

        DB::table('account_tags')->insert([
            ['name' => 'Customer', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Shipper', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ]);
    }
}
