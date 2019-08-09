<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'label', 'attributes', 'content', 'type', 'active', 
    ];


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'elements';
}
