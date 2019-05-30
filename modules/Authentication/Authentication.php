<?php

namespace Modules\Authentication;

use App\Http\Classes\Module;

class Authentication extends Module
{

    public function __construct() {

        $this->name = 'Authentication';

        $this->description = 'This module allow auth user in back and front end';

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

        parent::updateConfiguration($this->name, 'Page Logout', 'Select Page to logout ', 'select-page', 5);

        parent::updateConfiguration($this->name, 'Logout Button', 'Add logout button ', 'design-page', 6);

        parent::updateConfiguration($this->name, 'Page Register', 'Select Page to register ', 'select-page', 7);

        parent::updateConfiguration($this->name, 'Design Register', 'Configurate Design of register', 'design-page', 8);

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


}
