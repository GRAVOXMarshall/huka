<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'layouts';

    protected $fillable = ['name', 'active'];

}
