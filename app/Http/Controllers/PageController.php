<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Classes\Page;
use App\Http\Controllers\Controller;
use Validator;

class PageController extends Controller
{

    /**
     * load main page content
     * @return view
     */
    public function __invoke(){
        $front = Page::where('type', 'F')->get();
        $back = Page::where('type', 'B')->get();
        return view('back/pages', compact('front', 'back'));
    }

    /**
     * load form to edit and add page 
     * @param Object Page
     * @return view
     */
    public function showForm(Page $page){
        if (is_null($page->id)) {
            return view('back/form/page');
        }else{
            return view('back/form/page', compact('page'));
        }
    }

    /**
     * Add new page to database
     * @param Object Request
     * @return view
     */
    public function addPage(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'title' => 'required|string',
            'type' => 'required|string|in:F,B',
            'description' => 'required|string',
            'link' => 'required|string|unique:pages'
        ]);

        if (!$validator->fails()) {
            $page = new Page;
            $page->name = $request->name;
            $page->title = $request->title;
            $page->type = $request->type;
            $page->link = $request->link;
            $page->active = (isset($request->active)) ? true : false;
            $page->description = $request->description;
            if ($page->save()) {
                return redirect('admin/dashboard/pages');
            }
        }

        return redirect('admin/dashboard/pages/add')
                        ->withErrors($validator)
                        ->withInput($request->input());
    }

    /**
     * Edit page in database
     * @param Object Request
     * @return view
     */
    public function editPage(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'title' => 'required|string',
            'type' => 'required|string|in:F,B',
            'description' => 'required|string',
            'link' => 'required|string|unique:pages,link,'.$request->page
        ]);
        if (!$validator->fails()) {
            $page = Page::findOrFail((int)$request->page);
            $page->name = $request->name;
            $page->title = $request->title;
            $page->type = $request->type;
            $page->link = $request->link;
            $page->active = (isset($request->active)) ? true : false;
            $page->description = $request->description;
            if ($page->save()) {
                return redirect('admin/dashboard/pages');
            }
        }

        return redirect('admin/dashboard/pages/edit/'.$request->page)
                        ->withErrors($validator);
    }

    /**
     * Delete page to database
     * @param Object Page
     * @return view
     */
    public function deletePage(Page $page){
        if (isset($page) && !is_null($page->id) && $page->delete()) {
            return redirect('admin/dashboard/pages')->with('status', 'Page deleted!');
        }

        return redirect('admin/dashboard/pages');
    }

    /**
     * Load front end
     *
     * @return view
     */
    public function loadFrontEnd(Page $page)
    {
        if (!empty($page)) {
            $components = json_decode($page->components, true);
            return view('index', [
            	'page' => $page,
            	'components' => json_decode($components, true),
            	'css' => $page->css,
                'template' => 'css/bootstrap-new.css'
            ]);
        }

        return redirect('/');
    }


}
