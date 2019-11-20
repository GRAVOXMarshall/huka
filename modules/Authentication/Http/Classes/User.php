<?php

namespace Modules\Authentication\Http\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Authentication\Authentication;

class User extends Authenticatable
{

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getColumns()
    {
        $result = DB::select('SHOW COLUMNS FROM users');
        $columns = array();
        foreach ($result as $value) {
            if ($value->Field != 'id' && $value->Field != 'remember_token' && $value->Field != 'created_at' && $value->Field != 'updated_at') {
                array_push($columns, ['name' => $value->Field, 'key' => $value->Key]);
            }
        }
        return $columns;
    }
    
}