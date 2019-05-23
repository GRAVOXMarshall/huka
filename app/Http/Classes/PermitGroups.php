<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class PermitGroups extends Model
{
    //
    protected $table = "permit_group";

    protected $fillable = ['permit_id', 'groups_id'];
}
