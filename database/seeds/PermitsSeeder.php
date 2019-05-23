<?php

use Illuminate\Database\Seeder;
use App\Http\Classes\Permit;

class PermitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Permit::create([
        	'name' => 'Permit 1'
        ]);

        Permit::create([
        	'name' => 'Permit 2'
        ]);

        Permit::create([
        	'name' => 'Permit 3'
        ]);
    }
}
