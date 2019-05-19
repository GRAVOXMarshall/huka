<?php

use Illuminate\Database\Seeder;

class ModulesConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Authentication Configuration 

        DB::table('module_configuration')->insert([
            'module_id' => 1,
            'name' => 'Database',
            'description' => 'Configurate Databese',
            'step' => 1
        ]);

        DB::table('module_configuration')->insert([
            'module_id' => 1,
            'name' => 'Option Login',
            'description' => 'Select login type',
            'step' => 2
        ]);

        DB::table('module_configuration')->insert([
            'module_id' => 1,
            'name' => 'Page Login',
            'description' => 'Select Page to login',
            'step' => 3
        ]);

        DB::table('module_configuration')->insert([
            'module_id' => 1,
            'name' => 'Design Login',
            'description' => 'Configurate Design of login',
            'step' => 4
        ]);
    }
}
