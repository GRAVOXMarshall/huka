<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'templates';

    protected $fillable = ['web_id', 'name', 'route', 'route_css', 'active'];
}
