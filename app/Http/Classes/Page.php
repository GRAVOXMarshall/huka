<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

    protected $fillable = ['name', 'title', 'description', 'link', 'type', 'active'];
}
