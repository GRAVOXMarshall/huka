<?php

use Illuminate\Database\Seeder;
use App\Http\Classes\ModuleConfigure;


class ModulesConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' => 'Database',
        	'description' => 'Configurate Database',
        	'type' => 'config-database',
        	'value' => '{"columns":["firstname","lastname","email","password"],"username":"email","password":"password"}',
        	'step' => 1
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' => 'Option Login',
        	'description' =>  'Select login type',
        	'type' =>  'login-type',
        	'value' =>  '{"type":"1"}',
        	'step' => 2
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' =>  'Page Login',
        	'description' =>  'Select Page to login',
        	'type' =>  'select-page',
        	'value' =>  '{"option":"page","value":"2"}',
        	'step' => 3 
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' =>  'Design Login',
        	'description' =>  'Configurate Design of login',
        	'type' =>  'design-page',
        	'value' =>  '{"design":"save"}',
        	'step' => 4 
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' =>  'Add login trigger',
        	'description' =>  'Select where you want to add the button that redirect to the login',
        	'type' =>  'select-page',
        	'value' =>  '{"option":"layout","value":"1"}',
        	'step' => 5 
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' =>  'Design login trigger',
        	'description' =>  'Configurate Design of login trigger',
        	'type' =>  'design-page',
        	'value' =>  '{"design":"save"}',
        	'step' => 6 
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' =>  'Page Logout',
        	'description' =>  'Select Page to logout ',
        	'type' =>  'select-page',
        	'value' =>  '{"option":"layout","value":"1"}',
        	'step' => 7 
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' =>  'Logout Button',
        	'description' =>  'Add logout button ',
        	'type' =>  'design-page',
        	'value' =>  '{"design":"save"}',
        	'step' => 8 
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' =>  'Page Register',
        	'description' =>  'Select Page to register ',
        	'type' =>  'select-page',
        	'value' =>  '{"option":"page","value":"3"}',
        	'step' => 9
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' =>  'Design Register',
        	'description' =>  'Configurate Design of register',
        	'type' =>  'design-page',
        	'value' =>  '{"design":"save"}',
        	'step' => 10 
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' =>  'Set User Information',
        	'description' =>  'Set user information',
        	'type' =>  'user-information',
        	'value' =>  '{"Nombre":"firstname","Apellido":"lastname","content_option_information":"layout","layout":"1"}',
        	'step' => 11 
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' =>  'Design User Information',
        	'description' =>  'Configurate Design of user information',
        	'type' =>  'design-page',
        	'value' => '{"design":"save"}' ,
        	'step' => 12 
        ]);

        ModuleConfigure::create([
        	'module_id' => 1,
        	'name' =>  'User pages',
        	'description' =>  'Select the pages to which only logged users can enter',
        	'type' =>  'user-page',
        	'value' =>  '{"pages":null}',
        	'step' => 13 
        ]);
    }
}
