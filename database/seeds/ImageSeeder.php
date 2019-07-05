<?php

use Illuminate\Database\Seeder;
use App\Http\Classes\Image;


class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         Image::create([
            'name' => "cx.png",
            'src' => "/storage/images/p3scxXbUQwSYTFU3PtdvJQzbf2Zf0ZnIkuBS1Gaa.png"

        ]);

         Image::create([
            'name' => "500.jpg",
            'src' => "/storage/images/m4MfSMz6lFBM9UtRm60MsH7lNYB4DaxWhc9pynqp.jpeg"

        ]);
    }
}
