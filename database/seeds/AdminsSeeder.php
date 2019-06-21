<?php

use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('admins')->insert([
            'firstname' => 'Matias',
            'lastname' => 'Matias',
            'email' => 'matias@gmail.cl',
            'password' => bcrypt("123456"),
            'is_admin' => 2,
            'group_id' => 1
        ]);
    }
}
