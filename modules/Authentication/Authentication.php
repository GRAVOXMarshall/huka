<?php

namespace Modules\Authentication;

use App\Http\Classes\Module;
use App\Http\Classes\Element;
use App\Http\Classes\ElementTrait;
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

        parent::updateConfiguration($this->name, 'User pages', 'Select the pages to which only logged users can enter', 'user-page', 13);

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
    public function executeSentence($component, $sentence, $value = null)
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

    public function getConfigValue()
    {
        if (!is_null($module = $this->getByName($this->name))) {
            return json_decode($module->configuration);
        }
    }

    public function updateConfigValue($value)
    {
        if (!is_null($value) && !is_null($module = $this->getByName($this->name))) {
            if (is_null($module->configuration)) {

                $configuration = json_decode($value);
                $register = "";
                $login = ""; 
                foreach ($configuration->fields as $field) {
                    $register .= "<div style='margin-bottom: 1rem;'><input data-gjs-type='form_input' type='".strtolower($field->type)."' name='".$field->name."' placeholder='".$field->name."'></div>";
                    if ($field->login) {
                        $login .= "<div style='margin-bottom: 1rem;'><input data-gjs-type='login_input' type='".strtolower($field->type)."' name='".$field->name."' placeholder='".$field->name."'></div>";
                    }
                }

                Element::create([
                    'name' => "register",
                    'label' => "Register Form",
                    'attributes' => json_encode(array(
                        "class" => "fa fa-wpforms"
                    )), 
                    "content" => "\" <form data-gjs-type='register' action='".route('authentication.register')."' method='post'>".$register."<button data-gjs-type='button' type='submit'>Register</button></form> \" ",
                    'type' => 'M',
                    'active' => true,
                    'module_id' => $module->id
                ]);

                Element::create([
                    'name' => "login",
                    'label' => "Login Form",
                    'attributes' => json_encode(array(
                        "class" => "fa fa-wpforms"
                    )), 
                    "content" => "\" <form data-gjs-type='login' action='".route('authentication.login')."' method='post'>".$login."<button data-gjs-type='button' type='submit'>Sign in</button></form> \" ",
                    'type' => 'M',
                    'active' => true,
                    'module_id' => $module->id
                ]);

                Element::create([
                    'name' => "logout",
                    'label' => "Logout Button",
                    'attributes' => json_encode(array(
                        "class" => "fa fa-wpforms"
                    )), 
                    "content" => "\" <form data-gjs-type='logout' action='".route('authentication.logout')."' method='post'><button data-gjs-type='button' type='submit'>Logout</button></form> \" ",
                    'type' => 'M',
                    'active' => true,
                    'module_id' => $module->id
                ]);

                $options = array(
                    array('value' => 'button', 'name'  => 'Button'),
                    array('value' => 'checkbox', 'name'  => 'Checkbox'),
                    array('value' => 'color', 'name'  => 'Color'),
                    array('value' => 'date', 'name'  => 'Date'),
                    array('value' => 'datetime-local', 'name'  => 'Datetime local'),
                    array('value' => 'email', 'name'  => 'Email'),
                    array('value' => 'file', 'name'  => 'File'),
                    array('value' => 'hidden', 'name'  => 'Hidden'),
                    array('value' => 'image', 'name'  => 'Image'),
                    array('value' => 'month', 'name'  => 'Month'),
                    array('value' => 'number', 'name'  => 'Mumber'),
                    array('value' => 'password', 'name'  => 'Password'),
                    array('value' => 'radio', 'name'  => 'Radio'),
                    array('value' => 'range', 'name'  => 'Range'),
                    array('value' => 'reset', 'name'  => 'Reset'),
                    array('value' => 'search', 'name'  => 'Search'),
                    array('value' => 'submit', 'name'  => 'Submit'),
                    array('value' => 'tel', 'name'  => 'Tel'),
                    array('value' => 'text', 'name'  => 'Text'),
                    array('value' => 'time', 'name'  => 'Time'),
                    array('value' => 'url', 'name'  => 'Url'),
                    array('value' => 'week', 'name'  => 'Week'),
                );

                ElementTrait::create([
                    'name' => "form_input",
                    'values' => json_encode(
                        [
                            'placeholder'
                        ]
                    )
                ]);
            }

            $module->configuration = $value;
            if ($module->save()) {
                return true;
            }
        }

        return false;
    }

}
