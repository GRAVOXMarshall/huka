<?php

namespace App\Http\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

	use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password',
    ];

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
            if ($value->Field != 'id') {
                array_push($columns, ['name' => $value->Field, 'key' => $value->Key]);
            }
        }
        return $columns;
    }
    
}
