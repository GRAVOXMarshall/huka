<?php

namespace Modules\Authentication\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Authentication\Authentication;
use Modules\Authentication\Http\Classes\User;
use App\Http\Classes\Image;
use App\Http\Classes\Page;
use App\Http\Classes\Layout;
use App\Http\Classes\Element;
use App\Http\Classes\ModuleConfigure;
use App\Http\Classes\Configuration;

class ConfiguratesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function displayConfigurationsForm()
    {
        $module = new Authentication();
        $configuration = $module->getConfigValue();
        $fields = [];
        if (is_null($configuration)) {
            $fields = User::getColumns();
        }else{
            $fields = $configuration->fields;
        }

        $returnHTML = view('authentication::form', compact('fields', 'configuration'))->render();
        return response()->json(array('success' => true, 'html' => $returnHTML, 'fields' => $fields, 'configuration' => $configuration));
    }

    /**
     * Save new configuration of module in the modale
     * @return Response
     */
    public function processSaveConfiguration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:1,2',
            'session_time' => 'required|integer',
            'fail_number' => 'required|integer'
        ]);

        if (!$validator->fails()) {

            $columns = User::getColumns();
            $code = 'Schema::table("users", function ($table) {'."\n";
            $inputs = $request->input_auth;
            $selects = $request->select_auth;
            $checkets = $request->check_login;
            $fields = array();
            // In this for we create de code to execute to insert, edit or delete fields in the database
            foreach ($columns as $column) {
                $delete = true;
                for ($i=0; $i < count($inputs); $i++) {
                    if ($column['name'] == $inputs[$i]) {
                        $delete = false;
                    }
                }
                if ($delete) {
                    $code.= '$table->dropColumn("'.$column['name'].'");'."\n";
                }elseif ($column['key'] == 'UNI') {
                    $code .= '$table->dropUnique("users_'.$column['name'].'_unique");'."\n";
                }
            }


            for ($i=0; $i < count($inputs); $i++) { 
                $edit_column = false;
                foreach ($columns as $column) {
                    if ($column['name'] == $inputs[$i]) {
                        $edit_column = true;
                    }
                }

                $code.= '$table->';
                switch ($selects[$i]) {
                    case 'TEXT':
                        $code .= 'text("'.$inputs[$i].'")';
                        break;
                    case 'EMAIL':
                        $drop_unique = true;
                        $code .= 'string("'.$inputs[$i].'", 150)->unique()';
                        break;
                    case 'PASSWORD':
                        $code .= 'string("'.$inputs[$i].'")';
                        break;
                    case 'NUMBER':
                        $code .= 'integer("'.$inputs[$i].'")';
                        break;
                    case 'DATE':
                        $code .= 'date("'.$inputs[$i].'")';
                        break;
                }
                if ($edit_column ) {
                    $code .= '->change()';
                }

                $code .= ';'."\n";

                array_push($fields, [
                    'name' => $inputs[$i],
                    'type' => $selects[$i],
                    'login' => ((int)$checkets[$i] == 1) ? true : false
                ]);
            }

            $code .= '});';
            eval($code);

            $values = json_encode(array(
                'type' => $request->type,
                'session_time' => $request->session_time,
                'fail_number' => $request->fail_number,
                'fields' => $fields,
            ));
            $module = new Authentication();
            return response()->json([
                'is_error' => $module->updateConfigValue($values),
                'values' => $values,
                'code' => $code,
                'result' => DB::select('SHOW COLUMNS FROM users')
            ]);
        }else{
            return response()->json([
                'is_error' => true,
                'result' => (!is_null($validator)) ? $validator->errors() : 'Request is invalidate.',
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function displayConfigurations()
    {
        $columns = array();
        $result = DB::select('SHOW COLUMNS FROM users');
        foreach ($result as $value) {
            array_push($columns, $value->Field);
        }
        $module = new Authentication();
        $configurations = $module->getConfigurations();
        $steps = array();
        foreach ($configurations as $configuration) {
            $steps[(int)$configuration->step] = $configuration->value;
        }
        $images = Image::all();
        $pages = Page::all();
        $layouts = Layout::all();
        // Get active elements in db 
        $elements = Element::where('active', 1)->get();
        return view('authentication::configuration', compact('module', 'columns', 'configurations', 'steps', 'pages', 'layouts', 'elements', 'images'));
    }
    
    /**
     * Save configuration database through ajax process
     * @param Request
     * @return Response
     */
    public function processConfigurationDataBase(Request $request)
    {
        $inputs = [
            'configuration' => 'required|exists:module_configuration,id',
            'columns' => 'required',
            'username' => 'required|string',
            'password' => 'required|string',
        ];
        $validator = ModuleConfigure::validateRequest($request, $inputs);
        if (!is_null($validator) && !$validator->fails()) {
            $value = json_encode(array(
                'columns' => $request->columns,
                'username' => $request->username,
                'password' => $request->password,
            ));
            return response()->json(ModuleConfigure::saveConfiguration((int)$request->configuration, $value));
        }
        return response()->json([
            'is_error' => true,
            'result' => (!is_null($validator)) ? $validator->errors() : 'Request is invalidate.',
        ]);
    }

    /**
     * Save configuration type login through ajax process
     * Type 1 is a classic login and 2 is modal login
     * @param Request
     * @return Response
     */
    public function processConfigurationTypeLogin(Request $request)
    {
        $inputs = [
            'configuration' => 'required|exists:module_configuration,id',
            'type' => 'required|integer',
        ];
        $validator = ModuleConfigure::validateRequest($request, $inputs);
        if (!is_null($validator) && !$validator->fails()) {
            $value = json_encode(array(
                'type' => $request->type
            ));
            return response()->json(ModuleConfigure::saveConfiguration((int)$request->configuration, $value));
        }
        return response()->json([
            'is_error' => true,
            'result' => (!is_null($validator)) ? $validator->errors() : 'Request is invalidate.',
        ]);
        
    }
    
    /**
     * Save configuration type login through ajax process
     * @param Request
     * @return Response
     */
    public function processConfigurationPage(Request $request)
    {
        $inputs = [
            'configuration' => 'required|exists:module_configuration,id',
            'content_option' => 'required|in:page,layout',
        ];
        $validator = ModuleConfigure::validateRequest($request, $inputs);
        if (!is_null($validator) && !$validator->fails()) {
            $value = json_encode(array(
                'option' => $request->content_option,
                'value' => ($request->content_option == 'page') ? $request->page : $request->layout,
            ));
            return response()->json(ModuleConfigure::saveConfiguration((int)$request->configuration, $value));
        }
        return response()->json([
            'is_error' => true,
            'result' => (!is_null($validator)) ? $validator->errors() : 'Request is invalidate.',
        ]);
        
    }

    /**
     * Save configuration dssign login through ajax process 
     * @param Request
     * @return Response
     */
    public function processConfigurationDesignLogin(Request $request)
    {
        $inputs = [
            'configuration' => 'required|exists:module_configuration,id',
        ];
        $validator = ModuleConfigure::validateRequest($request, $inputs);
        if (!is_null($validator) && !$validator->fails()) {
            $value = json_encode(array(
                'design' => 'save',
            ));
            return response()->json(ModuleConfigure::saveConfiguration((int)$request->configuration, $value));
        }
        return response()->json([
            'is_error' => true,
            'result' => (!is_null($validator)) ? $validator->errors() : 'Request is invalidate.',
        ]);

    }

    /**
     * Save configuration dssign login through ajax process 
     * @param Request
     * @return Response
     */
    public function processConfigurationUserInformation(Request $request)
    {
        $inputs = [
            'configuration' => 'required|exists:module_configuration,id',
            'content_option_information' => 'required|in:page,layout',
        ];

        $values = array();
        foreach ($request->all() as $key => $value) {
            if ($key != 'configuration' && $key != '_token') {
                $inputs[$key] = 'required|string';
                $values[$key] = $value;
            }
        }
        
        $validator = ModuleConfigure::validateRequest($request, $inputs);
        if (!is_null($validator) && !$validator->fails()) {
            $value = json_encode($values);
            return response()->json(ModuleConfigure::saveConfiguration((int)$request->configuration, $value));
        }
        return response()->json([
            'is_error' => true,
            'result' => (!is_null($validator)) ? $validator->errors() : 'Request is invalidate.',
        ]);

    }
    

    /**
     * Save configuration dssign login through ajax process 
     * @param Request
     * @return Response
     */
    public function processConfigurationUserPages(Request $request)
    {
        $inputs = [
            'configuration' => 'required|exists:module_configuration,id',
        ];

        $validator = ModuleConfigure::validateRequest($request, $inputs);
        if (!is_null($validator) && !$validator->fails()) {
            if (isset($request->pages) && !is_null($request->pages)) {
                // Remove user_page to page not select
                $pages = Page::where('user_page', true)->get();
                foreach ($pages as $page) {
                    if (!in_array($page->id, $request->pages)) {
                        $page->user_page = false;
                        $page->save();
                    }
                }
                // Add user_page to page select
                foreach ($request->pages as $id) {
                    $page = Page::find((int)$id);
                    $page->user_page = true;
                    $page->save();
                }
            }
            $value = json_encode(array(
                'pages' => (isset($request->pages) && !is_null($request->pages)) ? $request->pages : null,
            ));
            return response()->json(ModuleConfigure::saveConfiguration((int)$request->configuration, $value));
        }
        return response()->json([
            'is_error' => true,
            'result' => (!is_null($validator)) ? $validator->errors() : 'Request is invalidate.',
        ]);

    }

}
