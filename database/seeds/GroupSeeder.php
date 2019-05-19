<?php

use Illuminate\Database\Seeder;
use App\Http\Classes\Groups;
class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Groups::create([
        	'name' => 'Super Admin'
        ]);
    }
}
