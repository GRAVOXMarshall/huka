<?php

namespace Modules\UserAccount;

use App\Http\Classes\Module;
use Illuminate\Support\Facades\Auth;
use App\Http\Classes\ModuleConfigure;

class UserAccount extends Module
{

    public function __construct() {

        $this->name = 'UserAccount';

        $this->description = 'This module allow auth user in back and front end';

        $this->parent = 'Authentication';
        
        $this->has_variable = true;
        //parent::__construct();
    }

    /**
     * @return bool
     */
    public function install()
    {   
        if (!parent::install()) {
            return false;
        }
        
        parent::updateConfiguration($this->name, 'Variables', 'Configurate Variables', 'config-variables', 1);

        parent::updateConfiguration($this->name, 'Page Login', 'Select Page to login', 'select-page', 2);

        parent::updateConfiguration($this->name, 'Design Login', 'Configurate Design of login', 'design-page', 3);

        if (empty($this->error)) {
            return true;
        }

        return false;
    }

    public function uninstall()
    {
    
        if (!parent::uninstall()) {
            return false;
        }

        return true;
    }

    /**
     * Validate if a module is already registered in database
     * @param string
     * @return bool result
     */
    public function getVariable()
    {
        $variables = array();
        if ($user = Auth::guard('front')->user()) {
            if (!is_null($module = $this->getByName($this->name))) {
                $configuration = ModuleConfigure::where('module_id', $module->id)
                                ->where('step', 1)
                                ->firstOrFail();
                foreach (json_decode($configuration->value) as $key => $value) {
                    $variables[strtolower($key)] = $user->$value;
                }
            }
        }

        return $variables;
    }

}
