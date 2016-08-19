<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CompaniesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');

        DB::table('companies')->delete();

        DB::table('companies')->insert([
            [
                'id' => 1,
                'name' => 'Lantigua Lab',
                'firstname' => '',
                'lastname' => '',
                'phone' => '',
                'fax' => '',
                'email' => '',
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]
        ]);
    }
}
