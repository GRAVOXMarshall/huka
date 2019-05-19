<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class Functionality extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'functionalities';

    protected $fillable = ['parent_id', 'web_id', 'name', 'description', 'route', 'route_module', 'icon', 'active'];
}
