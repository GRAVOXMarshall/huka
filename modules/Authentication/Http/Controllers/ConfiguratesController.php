<?php

namespace Modules\Authentication\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Authentication\Authentication;
use App\Http\Classes\Image;
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
        $module = new Authentication();
        $configurations = $module->getConfigurations();
        $steps = array();
        foreach ($configurations as $configuration) {
            $steps[(int)$configuration->step] = $configuration->value;
        }
        $images = Image::all();
        $pages = Page::all();
        // Get active elements in db 
        $elements = Element::where('active', 1)->get();
        return view('authentication::configuration', compact('module', 'columns', 'configurations', 'steps', 'pages', 'elements', 'images'));
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
            'page' => 'required|exists:pages,id',
        ];
        $validator = ModuleConfigure::validateRequest($request, $inputs);
        if (!is_null($validator) && !$validator->fails()) {
            $value = json_encode(array(
                'page' => $request->page,
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

}
