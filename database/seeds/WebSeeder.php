<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Http\Classes\Web;

class WebSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Web::create([
            'name' => "Google",
            'domain' => "google.com",
            'reference' => 0

        ]);
    }
}
