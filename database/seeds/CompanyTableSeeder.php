<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CompanyTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->truncate();

        DB::table('companies')->insert([
            ['name' => 'Lantigua Group', 'shortname' => 'LG'],
        ]);
    }
}
