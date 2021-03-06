<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'firstname' => 'Matias',
            'lastname' => 'Perez',
            'email' => 'matias@gmail.com',
            'password' => bcrypt("123456"),
            'is_admin' => 2,
            'group_id' => 1
        ]);
    }
}
