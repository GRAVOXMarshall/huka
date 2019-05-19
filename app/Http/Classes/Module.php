<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'modules';

    protected $fillable = ['parent_id', 'web_id', 'name', 'description', 'route', 'icon', 'active'];

    /**
     * Insert module into datable
     */
    public function install()
    {
        // Check if module is installed
        /*
        $result = Module::isInstalled($this->name);
        if ($result) {
            $this->_errors[] = Tools::displayError('This module has already been installed.');
            return false;
        }

        // Install module and retrieve the installation id
        $result = Db::getInstance()->insert($this->table, array('name' => $this->name, 'active' => 1));

        if (!$result) {
            $this->_errors[] = Tools::displayError('Technical error: PrestaShop could not install this module.');
            return false;
        }
        $this->id = Db::getInstance()->Insert_ID();

        return true;
        */
    }

     /**
     * Delete module from datable
     *
     * @return bool result
     */
    public function uninstall()
    {
    	/*
        // Check module installation id validation
        if (!Validate::isUnsignedId($this->id)) {
            $this->_errors[] = Tools::displayError('The module is not installed.');
            return false;
        }

        // Disable the module for all shops
        $this->disable(true);


        // Uninstall the module
        if (Db::getInstance()->execute('DELETE FROM `'._DB_PREFIX_.'module` WHERE `id_module` = '.(int)$this->id)) {
            return true;
        }

        return false;
        */
    }

}
