<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configuration';

    protected $fillable = ['name', 'value'];

    public static function get($name = null)
    {
    	if (is_null($name) || empty($name)) {
    		return null;
    	}
        $configuration = Configuration::where('name', '=', $name)->firstOrFail();
        return $configuration->value;
    }

    public static function set($name = null, $value = null)
    {
    	if (!is_null($name) && !empty($name) && !is_null($value) && !empty($value)) {
    		if (Configuration::create(['name' => $name, 'value' => $value])) {
    			return true;
    		}
    	}
 
        return false;
    }
}
