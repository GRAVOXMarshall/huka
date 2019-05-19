<?php

use Illuminate\Database\Seeder;
use App\Admin;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::create([
            'firstname' => "Matias",
            'lastname' => "Perez",
            'email' => "matias@gmail.com",
            'password' => bcrypt("123456"),
            'is_admin' => 2,
            'group_id' => 1
        ]);
    }
}
