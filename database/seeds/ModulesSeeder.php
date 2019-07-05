<?php

use Illuminate\Database\Seeder;
use App\Http\Classes\Module;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Authentication Module 
        Module::create([
        	'name' => 'Authentication',
        	'description' => 'This module allow auth user in back and front end',
        	'parent' => null,
        	'active' => 0,
        ]);
        
    }
}
