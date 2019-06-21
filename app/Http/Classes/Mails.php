<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class Mails extends Model
{
    //
    protected $table = 'mails';

    protected $fillable = ['name', 'active'];
}
