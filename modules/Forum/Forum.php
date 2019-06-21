<?php

namespace Modules\Forum;

use App\Http\Classes\Module;
use Illuminate\Support\Facades\Auth;
use App\Http\Classes\ModuleConfigure;

class Forum extends Module
{

    public function __construct() {

        $this->name = 'Forum';

        $this->description = 'Corum Module';

        //$this->parent = 'Authentication';
        
        //$this->has_variable = true;
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
        parent::updateConfiguration($this->name, 'Home', 'Home View', 'home-view', 1);

        parent::updateConfiguration($this->name, 'Comments View', 'Comments View', 'select-page', 2);

        parent::updateConfiguration($this->name, 'Comment View Layout', 'Comment View Layout', 'design-page', 3);

        parent::updateConfiguration($this->name, 'Comment Creation View', 'Comment Creation View', 'select-page', 4);

        parent::updateConfiguration($this->name, 'Comment Creation View Design', 'Comment Creation View Design', 'design-page', 5);

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
}
