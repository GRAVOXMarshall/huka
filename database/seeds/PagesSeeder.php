<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('pages')->truncate();

        DB::table('pages')->insert([
            'name' => 'Home',
            'title' => Str::random(10),
            'description' => Str::random(10),
            'link' => Str::random(10),
            'type' => 'F',
            'active' => true,
            'main' => true, 
            'user_page' => false
        ]);
    }
}
