<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UsersSeeder::class);
    	$this->call(WebSeeder::class);
    	$this->call(PagesSeeder::class);
        $this->call(ElementSeeder::class);
        $this->call(ModulesSeeder::class);
        $this->call(ModulesConfigSeeder::class);
        
    }
}
