<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    protected $fillable = ['name', 'src'];
}
