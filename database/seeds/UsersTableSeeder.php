<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');

        DB::table('users')->delete();

        DB::table('users')->insert([
            [
                'id' => 1,
                'company_id' => 1,
                'role_id' => 1,
                'firstname' => 'Slic',
                'lastname' => 'Vic',
                'email' => 'vmlantigua@gmail.com',
                'password' => '$2y$10$LZbI1c3hpL2B1IDFSAi/A.0UiYGuMmIwrS3u5kztebuHekJdqM3u6',
                'active' => 1,
                'activation_code' => '',
                'remember_token' => '',
                'logins' => 0,
                'last_login' => $timestamp,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ]
        ]);
    }
}
