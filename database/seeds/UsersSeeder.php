<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => 'Nicolas',
            'lastname' => 'Marshall',
            'email' => 'n.marshall@hotmail.cl',
            'password' => bcrypt("123456")
        ]);
    }
}
