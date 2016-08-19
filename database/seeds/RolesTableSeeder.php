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
        $timestamp = date('Y-m-d H:i:s');

        DB::table('roles')->delete();

        DB::table('roles')->insert([
            ['name' => 'Super Admin', 'description' => 'Administrative user, has access to everything', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Super Agent', 'description' => 'Company owner or primary contact', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Customer', 'description' => 'Company customer or client', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Agent', 'description' => 'Company staff', 'created_at' => $timestamp, 'updated_at' => $timestamp],
            ['name' => 'Admin', 'description' => 'Administrative user', 'created_at' => $timestamp, 'updated_at' => $timestamp],
        ]);
    }
}
