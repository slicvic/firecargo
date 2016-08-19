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
        $createdAt = date('Y-m-d H:i:s');

        DB::table('users')->delete();

        DB::table('users')->insert([
            [
                'id' => 1,
                'company_id' => 1,
                'role_id' => 1,
                'firstname' => 'Slic',
                'lastname' => 'Vic',
                'email' => 'vmlantigua@gmail.com',
                'password' => '$2y$10$F6qNSi3uFaE47opz3UItTuIbuGK53xO2kI7uLLnALfyFlnTE89j.u',
                'active' => 1,
                'activation_code' => '',
                'remember_token' => '',
                'logins' => 0,
                'last_login' => $createdAt,
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ]
        ]);
    }
}
