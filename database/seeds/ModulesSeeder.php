<?php

use Illuminate\Database\Seeder;

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

        DB::table('modules')->insert([
            'name' => 'Authentication',
            'description' => 'Module to login and register',
            'route' => 'route',
            'icon' => 'icon',
            'active' => true,
        ]);
    }
}
