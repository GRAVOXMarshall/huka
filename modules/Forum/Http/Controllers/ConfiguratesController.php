<?php

namespace Modules\Forum\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Forum\Forum;
use App\Http\Classes\Image;
use App\Http\Classes\Page;
use App\Http\Classes\Element;
use App\Http\Classes\ModuleConfigure;
use App\Http\Classes\Configuration;
use Modules\Forum\Http\Classes\ForumComments;


class ConfiguratesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function displayConfigurations()
    {
        $columns_users = array();
        $users = DB::select('SHOW COLUMNS FROM users');
        foreach ($users as $value) {
            array_push($columns_users, $value->Field);
        }

        $columns_topics = array();
        $topics = DB::select('SHOW COLUMNS FROM forum_topics');
        foreach ($topics as $value) {
            array_push($columns_topics, $value->Field);
        }

        $columns_comments = array();
        $comments = DB::select('SHOW COLUMNS FROM forum_comments');
        foreach ($comments as $value) {
            array_push($columns_comments, $value->Field);
        }

        $module = new Forum();
        $configurations = $module->getConfigurations();
        $steps = array();
        foreach ($configurations as $configuration) {
            $steps[(int)$configuration->step] = $configuration->value;
        }
        $images = Image::all();
        $pages = Page::all();
        // Get active elements in db 
        $elements = Element::where('active', 1)->get();
            
        return view('forum::index', compact('module', 'columns_users', 'columns_topics', 'columns_comments', 'configurations', 'steps', 'pages', 'elements', 'images'));
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
            'columns_users' => 'required',
            'columns_topics' => 'required',
            'columns_comments' => 'required',
            'topic_column' => 'required|string',
        ];
        $validator = ModuleConfigure::validateRequest($request, $inputs);
        if (!is_null($validator) && !$validator->fails()) {
            $value = json_encode(array(
                'users' => $request->columns_users,
                'topics' => $request->columns_topics,
                'comments' => $request->columns_comments,
                'topic_column' => $request->topic_column,
                'replys' => (isset($request->reply_comments)) ? true : false,
                'anonymous' => (isset($request->anonymous_user)) ? true : false,
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
    public function processConfigurationDesign(Request $request)
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


    public function createComments(Request $request){
        $title = $request->title;
        $comments = $request->comments;

        $comment = new ForumComments();

        $comment->title = $title;
        $comment->comments = $comments;

        if ($comment->save()) {
            echo 'Realizado con exito';
        }else{
            echo 'Fallo insert';
        }
    }
   /* public function test(Request $request){
        $inputs = [
            'configuration' => 'required|exists:module_configuration,id',
        ];
        /* $values = array();
        foreach ($request->all() as $key => $value) {
            if ($key != 'configuration' && $key != '_token' && $key != 'autoamticMsj' && $key != 'remiMsj') {
                //$inputs[$key] = 'required|string';
                $values[$key] = $value;
            }
        }  "dataTwo" => $values,*/
       
       /* $validator = ModuleConfigure::validateRequest($request, $inputs);
        if (!is_null($validator) && !$validator->fails()) {
            $value = json_encode(array(
                'data' => $request->checks,
                'automatic' => $request->autoamticMsj,
                'remitente' => $request->remiMsj,
               
            ));
            return response()->json(ModuleConfigure::saveConfiguration((int)$request->configuration, $value));
        }
        return response()->json([
            'is_error' => true,
            'result' => (!is_null($validator)) ? $validator->errors() : 'Request is invalidate.',
        ]);
    }*/

}
