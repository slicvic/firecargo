<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        DB::table('roles')->insert([
            ['name' => 'Super Admin', 'description' => 'Administrative user, has access to everything'],
            ['name' => 'Super Agent', 'description' => 'Company owner or primary contact'],
            ['name' => 'Customer', 'description' => 'Company customer or client'],
            ['name' => 'Agent', 'description' => 'Company staff'],
        ]);
    }
}
