<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class ModuleConfigure extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'module_configuration';

    protected $fillable = ['module_id', 'name', 'description', 'value', 'step'];
}
