<?php

namespace Modules\UserAccount\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\UserAccount\UserAccount;
use Modules\Authentication\Authentication;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
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
        $module = new UserAccount();
        $configurations = $module->getConfigurations();
        $steps = array();
        foreach ($configurations as $configuration) {
            $steps[(int)$configuration->step] = $configuration->value;
        }
        $images = Image::all();
        $pages = Page::all();
        // Get active elements in db 
        $elements = Element::where('active', 1)->get();

        $auth = new Authentication;
        $auth_value = $auth->getConfigurations()[0]->value;
        $columns = json_decode($auth_value)->columns;

        return view('useraccount::configuration', compact('module', 'configurations', 'steps', 'pages', 'elements', 'images', 'columns'));
    }

    public function processConfigurationVariables(Request $request)
    {   
        $inputs = array(
            'configuration' => 'required|exists:module_configuration,id'
        );
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
