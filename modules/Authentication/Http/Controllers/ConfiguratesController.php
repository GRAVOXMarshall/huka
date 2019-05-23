<?php

namespace Modules\Authentication\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Classes\Page;
use App\Http\Classes\Element;
use App\Http\Classes\ModuleConfigure;
use App\Http\Classes\Configuration;

class ConfiguratesController extends Controller
{
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
        $configurations = DB::select('select * from module_configuration where module_id = :id', ['id' => 1]);
        $pages = Page::all();
        // Get active elements in db 
        $elements = Element::where('active', 1)->get();
        return view('authentication::configuration', compact('columns', 'configurations', 'pages', 'elements'));
    }

    /**
     * Validations of ajax process
     * @param Request
     * @return Response
     */
    public function processAjaxValidator(Request $request){
        $is_error = true;
        $columns = array();
        $validator = Validator::make($request->all(), [
            'table' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $is_error = false;
            $result = DB::select('SHOW COLUMNS FROM '.$request->table);
            foreach ($result as $value) {
                array_push($columns, $value->Field);
            }
        }
        return response()->json([
            'is_error' => $is_error,
            'result' => $columns,
        ]);
    }

    /**
     * Save configuration through ajax process
     * @param Request
     * @return Response
     */
    public function processSaveConfiguration(Request $request){
        $is_error = false;
        $result = '';
        $validator = Validator::make($request->all(), [
            'configuration' => 'required|exists:module_configuration,id',
            'table' => 'required|string',
            'columns' => 'required'
        ]);

        if ($validator->fails()) {
            $is_error = true;
            $result = 'Invalidate configuration values';
        }else{
            $configuration = ModuleConfigure::find((int)$request->configuration);
            $configuration->value = json_encode(array(
                'table' => $request->table,
                'columns' => $request->columns
            ));
            if ($configuration->save()) {
                $result = 'Configuration save correctly';
            }else{
                $is_error = true;
                $result = 'Error lo save configuration';
            }
        }
            
        return response()->json([
            'is_error' => $is_error,
            'result' => $result,
        ]);
        
    }
    
    /**
     * Save configuration database through ajax process
     * @param Request
     * @return Response
     */
    public function processConfigurationDataBase(Request $request){
        $is_error = false;
        $result = '';
        $validator = Validator::make($request->all(), [
            'configuration' => 'required|exists:module_configuration,id',
            'columns' => 'required',
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $is_error = true;
            $result = 'Invalidate configuration values';
        }else{
            $configuration = ModuleConfigure::find((int)$request->configuration);
            $configuration->value = json_encode(array(
                'columns' => $request->columns,
                'username' => $request->username,
                'password' => $request->password,
            ));
            if ($configuration->save()) {
                $result = 'Configuration save correctly';
            }else{
                $is_error = true;
                $result = 'Error lo save configuration';
            }
        }
            
        return response()->json([
            'is_error' => $is_error,
            'result' => $result,
        ]);
        
    }

    /**
     * Save configuration type login through ajax process
     * Type 1 is a classic login and 2 is modal login
     * @param Request
     * @return Response
     */
    public function processConfigurationTypeLogin(Request $request){
        $is_error = false;
        $result = '';
        $validator = Validator::make($request->all(), [
            'configuration' => 'required|exists:module_configuration,id',
            'type' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $is_error = true;
            $result = 'Invalidate configuration values';
        }else{
            $configuration = ModuleConfigure::find((int)$request->configuration);
            $configuration->value = json_encode(array(
                'type' => $request->type
            ));
            if ($configuration->save()) {
                $result = 'Configuration save correctly';
            }else{
                $is_error = true;
                $result = 'Error lo save configuration';
            }
        }
            
        return response()->json([
            'is_error' => $is_error,
            'result' => $result,
        ]);
        
    }
    
    /**
     * Save configuration type login through ajax process
     * @param Request
     * @return Response
     */
    public function processConfigurationPage(Request $request){
        $is_error = false;
        $result = '';
        $validator = Validator::make($request->all(), [
            'configuration' => 'required|exists:module_configuration,id',
            'page' => 'required|exists:pages,id',
        ]);

        if ($validator->fails()) {
            $is_error = true;
            $result = 'Invalidate configuration values';
        }else{
            $configuration = ModuleConfigure::find((int)$request->configuration);
            $configuration->value = json_encode(array(
                'page' => $request->page,
            ));
            if ($configuration->save()) {
                $result = 'Configuration save correctly';
            }else{
                $is_error = true;
                $result = 'Error lo save configuration';
            }
        }
            
        return response()->json([
            'is_error' => $is_error,
            'result' => $result,
        ]);
        
    }

    /**
     * Get login page for use in editor
     * @param Request
     * @return Response
     */
    public function processAjaxLoginPage(Request $request){
        $is_error = false;
        $result;
        $validator = Validator::make($request->all(), [
            'configuration' => 'required|exists:module_configuration,id',
        ]);

        if ($validator->fails()) {
            $is_error = true;
            $result = 'Invalidate configuration values';
        }else{
            $configurations = DB::select('select * from module_configuration where module_id = :id', ['id' => 1]);
            $steps = array();
            foreach ($configurations as $configuration) {
                if ((int)$configuration->step != 3) {
                    $steps[(int)$configuration->step] = $configuration->value;
                }else{
                        // Aqui debo usar try catch 
                    $id_page = json_decode($configuration->value)->page;
                    $page = Page::where('id', (int)$id_page)->firstOrFail();
                    $steps[(int)$configuration->step] = json_encode($page);
                }
            }
            $result = $steps;
        }
        return response()->json([
            'is_error' => $is_error,
            'result' => $result,
        ]);
    }

    /**
     * Get login page for use in editor
     * @param Request
     * @return Response
     */
    public function processConfigurationDesignLogin(Request $request){
        $is_error = false;
        $result = '';
        $validator = Validator::make($request->all(), [
            'configuration' => 'required|exists:module_configuration,id',
        ]);

        if ($validator->fails()) {
            $is_error = true;
            $result = 'Invalidate configuration values';
        }else{
            $configuration = ModuleConfigure::find((int)$request->configuration);
            $configuration->value = json_encode(array(
                'design' => 'save',
            ));
            if ($configuration->save()) {
                $result = 'Configuration save correctly';
            }else{
                $is_error = true;
                $result = 'Error lo save configuration';
            }
        }
            
        return response()->json([
            'is_error' => $is_error,
            'result' => $result,
        ]);
    }


    /**
     * Get configurations for use in the step 
     * @param Request
     * @return Response
     */
    public function processAjaxGetConfigurations(Request $request){
        $is_error = false;
        $result;
        $validator = Validator::make($request->all(), [
            'configuration' => 'required|exists:module_configuration,id',
        ]);

        if ($validator->fails()) {
            $is_error = true;
            $result = 'Invalidate configuration values';
        }else{
            $configurations = DB::select('select * from module_configuration where module_id = :id', ['id' => 1]);
            $steps = array();
            foreach ($configurations as $configuration) {
                $steps[(int)$configuration->step] = $configuration->value;
            }
            $result = $steps;
        }
        return response()->json([
            'is_error' => $is_error,
            'result' => $result,
        ]);
    }
}
