<?php

namespace Modules\Authentication;

use App\Http\Classes\Module;
use Illuminate\Support\Facades\Auth;
use App\Http\Classes\ModuleConfigure;

class Authentication extends Module
{

    public function __construct() {

        $this->name = 'Authentication';

        $this->description = 'This module allow auth user in back and front end';

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
        parent::updateConfiguration($this->name, 'Database', 'Configurate Database', 'config-database', 1);

        parent::updateConfiguration($this->name, 'Option Login', 'Select login type', 'login-type', 2);

        parent::updateConfiguration($this->name, 'Page Login', 'Select Page to login', 'select-page', 3);

        parent::updateConfiguration($this->name, 'Design Login', 'Configurate Design of login', 'design-page', 4);

        parent::updateConfiguration($this->name, 'Add login trigger', 'Select where you want to add the button that redirect to the login', 'select-page', 5);

        parent::updateConfiguration($this->name, 'Design login trigger', 'Configurate Design of login trigger', 'design-page', 6);

        parent::updateConfiguration($this->name, 'Page Logout', 'Select Page to logout ', 'select-page', 7);

        parent::updateConfiguration($this->name, 'Logout Button', 'Add logout button ', 'design-page', 8);

        parent::updateConfiguration($this->name, 'Page Register', 'Select Page to register ', 'select-page', 9);

        parent::updateConfiguration($this->name, 'Design Register', 'Configurate Design of register', 'design-page', 10);

        parent::updateConfiguration($this->name, 'Set User Information', 'Set user information', 'user-information', 11);

        parent::updateConfiguration($this->name, 'Design User Information', 'Configurate Design of user information', 'design-page', 12);

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
                                ->where('step', 11)
                                ->firstOrFail();
                foreach (json_decode($configuration->value) as $key => $value) {
                    $variables[strtolower($key)] = $user->$value;
                }
            }
        }

        return $variables;
    }

    /**
     * Validate if a module is already registered in database
     * @param string
     * @return bool result
     */
    public function executeSentence($component, $sentence)
    {
        if (!is_null($component) && !is_null($sentence)) {
            switch ($sentence->type) {
                case 'if':

                    if(eval('return '.$sentence->value.';')){
                        switch ($sentence->option) {
                            case 'userNotLogin':
                            case 'userLogin':
                                $component->components = array();
                                break;
                        }
                    }
                    
                    break;
                
                default:
                    # code...
                    break;
            }
        }
    }

}
