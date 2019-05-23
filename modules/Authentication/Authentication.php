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
        parent::updateConfiguration($this->name, 'Database', 'Configurate Databese', 1);

        parent::updateConfiguration($this->name, 'Option Login', 'Select login type', 2);

        parent::updateConfiguration($this->name, 'Page Login', 'Select Page to login', 3);

        parent::updateConfiguration($this->name, 'Design Login', 'Configurate Design of login', 4);
        

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
