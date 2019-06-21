<?php

namespace Modules\Contact;

use App\Http\Classes\Module;

class Contact extends Module
{

    public function __construct() {

        $this->name = 'Contact';

        $this->description = 'This module allow create a contact form';

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
        parent::updateConfiguration($this->name, 'Main Configuration', 'Main Configuration', 'config-options', 1);

        parent::updateConfiguration($this->name, 'form view', 'form view', 'select-page', 2);

        parent::updateConfiguration($this->name, 'page design', 'page design', 'design-page', 3);

        //parent::updateConfiguration($this->name, 'choose mail design', 'choose mail design', 'choose-desing', 4);

        parent::updateConfiguration($this->name, 'choose mail design own', 'choose mail design own', 'select-page', 4);

        parent::updateConfiguration($this->name, 'see own mail design', 'see own mail design', 'design-page', 5);

        parent::updateConfiguration($this->name, 'choose mail design user', 'choose mail design user', 'select-page', 6);

        parent::updateConfiguration($this->name, 'see user mail design', 'see user mail design', 'design-page', 7);


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
