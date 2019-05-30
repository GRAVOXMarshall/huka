<?php

namespace App\Http\Classes;

use Illuminate\Support\Facades\DB;
use App\Http\Classes\ModuleConfigure;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'modules';

    protected $fillable = ['name', 'description'];

    public $name;

    public $description;

    public $error;

    /**
     * Insert module into database
     * @return bool result
     */
    public function install()
    {
        // Check if module is installed
        $result = $this->isInstalled($this->name);
        if ($result) {
            $this->error = 'This module has already been installed.';
            return false;
        }

        // Install module and retrieve the installation id
        $result = DB::table('modules')->insert([
            'name' => $this->name, 
            'description' => $this->description,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if (!$result) {
            $this->error = 'Problem to insert';
            return false;
        }

        return true;
    }

     /**
     * Delete module from datable
     *
     * @return bool result
     */
    public function uninstall()
    {  
        // Check if module is installed
        if (!$this->isInstalled($this->attributes['name'])) {
            $this->error = 'The module is not installed.';
            return false;
        }
        // Disable the module
        $this->active(false);

        $deletedRows = ModuleConfigure::where('module_id', $this->attributes['id'])->delete();

        // Uninstall the module
        if (parent::delete()) {
            return true;
        }

        return false;
    }

    /**
     * Validate if a module is already registered in database
     * @param string
     * @return bool result
     */
    public function isInstalled($name = null)
    {
        $result = false;
        if (!is_null($name)) {
            try {
                $module = Module::where('name', '=', $name)->first();
                if (!is_null($module)) {
                    $result = true;
                }
            } catch (Exception $e) {
                
            }
            
        }
        return $result;
    }

    /**
     * Update or register a module configuration
     * @param string to module_name, name and description
     * @param integer to step
     * @return bool result
     */
    public function updateConfiguration($module_name = null, $name = null, $description = null, $type = null, $step = 0)
    {
        if ($step > 0 && !is_null($module_name) && !is_null($name) && !is_null($description) && !is_null($type) && !is_null($module = $this->getByName($module_name))) {
            $configuration = ModuleConfigure::firstOrNew(['module_id' => $module->id, 'name' => $name]);
            $configuration->description = $description;
            $configuration->step = $step;
            $configuration->type = $type;
            if ($configuration->save()) {
                return true;
            }

        }
        $this->error = 'Problem to install this module.';
        return false;
    }

     /**
     * Get object module by name
     * @param string
     * @return Object Module
     */
    public function getByName($name = null)
    {
        if (!is_null($name)) {
            try {
                $module = Module::where('name', '=', $name)->first();
                if (!is_null($module)) {
                    return $module;
                }
            } catch (Exception $e) {
                
            }
        }
        $this->error = 'Module Invalid';
        return null;
    }

    /**
     * Active or disable module in db
     * @param bool
     * @return void
     */
    public function active($active = true)
    {
        $this->attributes['active'] = $active;
        parent::save();
    }

    /**
     * Get configurations module 
     * @return void
     */
    public function getConfigurations()
    {
        if (!is_null($module = $this->getByName($this->name))) {
            return ModuleConfigure::where('module_id', $module->id)->get();
        }
        return null;
    }
    

}
