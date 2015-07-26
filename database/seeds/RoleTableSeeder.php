<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RoleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        DB::table('roles')->insert([
            ['name' => 'Super Admin', 'description' => 'Administrative user, has access to everything.'],
            ['name' => 'Super Agent', 'description' => 'Owner / primary contact of a company.'],
            ['name' => 'Client', 'description' => 'Customer of a company.'],
        ]);
    }
}
