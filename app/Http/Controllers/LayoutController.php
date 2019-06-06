<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Classes\Layout;
use App\Http\Classes\Element;
use App\Http\Classes\Image;
use Validator;

class LayoutController extends Controller
{
    /**
     * load main layout content
     * @return view
     */
    public function __invoke(){
        $layouts = Layout::all();
        return view('back/layouts', compact('layouts'));
    }

    /**
     * load form to edit and add page 
     * @param Object Page
     * @return view
     */
    public function showForm(Layout $layout){
        if (is_null($layout->id)) {
            return view('back/form/layout');
        }else{
            return view('back/form/layout', compact('layout'));
        }
    }

    /**
     * Add new layout to database
     * @param Object Request
     * @return view
     */
    public function addLayout(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150|unique:layouts'
        ]);

        if (!$validator->fails()) {
            $layout = new Layout;
            $layout->name = $request->name;
            $layout->active = (isset($request->active)) ? true : false;
            if ($layout->save()) {
                return redirect('admin/dashboard/layouts');
            }
        }

        return redirect('admin/dashboard/layouts/add')
                        ->withErrors($validator)
                        ->withInput($request->input());
    }

    /**
     * Edit layout in database
     * @param Object Request
     * @return view
     */
    public function editLayout(Request $request){
        $validator = Validator::make($request->all(), [
        	'layout' => 'required|integer',
            'name' => 'required|string|max:150|unique:layouts,name,'.$request->layout
        ]);
        if (!$validator->fails()) {
            $layout = Layout::findOrFail((int)$request->layout);
            $layout->name = $request->name;
            $layout->active = (isset($request->active)) ? true : false;
            if ($layout->save()) {
                return redirect('admin/dashboard/layouts');
            }
        }

        return redirect('admin/dashboard/layouts/edit/'.$request->layout)
                        ->withErrors($validator);
    }

    /**
     * Delete layout to database
     * @param Object Page
     * @return view
     */
    public function deleteLayout(Layout $layout){
        if (isset($layout) && !is_null($layout->id) && $layout->delete()) {
            return redirect('admin/dashboard/layouts')->with('status', 'Layout deleted!');
        }

        return redirect('admin/dashboard/layouts');
    }

    /**
     * Load editor to design layout
     * @param Object Page
     * @return view
     */
    public function loadEditor(Layout $layout){
    	if (isset($layout) && !is_null($layout->id) && $layout->id > 0) {
    		$elements = Element::where('active', 1)->get();
	        $images = Image::all();
	        return view('editor/layout', compact('layout', 'elements', 'images'));
    	}
    }
	

	/**
     * Get configurate of layout
     * @param Object Page
     * @return Json
     */
    public function builderLayout(Layout $layout, Request $request)
    {
    	if (!empty($layout)) {
            $layout->css = json_encode($request['gjs-css']);
            $layout->styles = json_encode($request['gjs-styles']);
            $layout->assets = json_encode($request['gjs-assets']);
            $layout->components = json_encode($request['gjs-components']);
            $layout->save();

            return ['status' => 'success', 'message' => 'Your Page was successfully saved!'];
        }

        //Session::flash('flashSession', ['status' => 'danger', 'message' => 'Error, you cannot build this Page!']);
        return redirect('admin/dashboard/layouts');
    }

    /**
     * Save configurate page in db
     * @param Object Page
     * @param Object Request
     * @return Json
     */
    public function loadLayout(Layout $layout)
    {
        if (!empty($layout)) {
            return json_encode([
                'gjs-css' => json_decode($layout->css, true),
                'gjs-style' => json_decode($layout->styles, true),
                'gjs-assets' => json_decode($layout->assets, true),
                'gjs-components' => json_decode($layout->components, true),
            ]);
        }

        return 'Layout not found';

        //Session::flash('flashSession', ['status' => 'danger', 'message' => 'Error, you cannot build this Page!']);
        //return redirect('/');
    }

}	
