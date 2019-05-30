<?php

namespace App\Http\Classes;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class ModuleConfigure extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'module_configuration';

    protected $fillable = ['module_id', 'name', 'description', 'type', 'step'];


    /**
     * Validate request of a configuration
     * @param Request
     * @param Array
     * @return Validator Object
     */
    public static function validateRequest(Request $request, $inputs)
    {
        if (is_array($inputs)) {
            return Validator::make($request->all(), $inputs);   
        }

        return null;
    }

    /**
     * Save configurations in the database
     * @param Integer
     * @param JSON
     * @return Array
     */
    public static function saveConfiguration($id = 0, $value = null)
    {
        if ($id > 0 && !is_null($value) && !empty($value) && !is_null($configuration = parent::find((int)$id))) {
            $configuration->value = $value;
            if ($configuration->save()) {
                return [
                    'is_error' => false,
                    'result' => $configuration
                ];
            }
        }
        return [
            'is_error' => true,
            'result' => 'Error lo save configuration'
        ];
    }
    
}
