<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class ElementTrait extends Model
{
    //
    protected $table = 'traits';

    protected $fillable = ['name', 'values'];
}
