<?php

namespace Modules\Authentication\Http\Controllers;

use App\Http\Classes\Module;

class Authentication extends Module
{
    /**
     * @return bool
     * @throws PrestaShopException
     */
    public function install()
    {
        if (!parent::install()) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
    
        if (!parent::uninstall()) {
            return false;
        }

        return true;
    }


}
