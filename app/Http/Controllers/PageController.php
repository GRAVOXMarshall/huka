<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Classes\Page;
use App\Http\Classes\Layout;
use Illuminate\Support\Facades\Auth;
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
        $layouts = Layout::all();
        if (is_null($page->id)) {
            return view('back/form/page', compact('layouts'));
        }else{
            return view('back/form/page', compact('page', 'layouts'));
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
            'layout' => 'required|integer',
            'description' => 'required|string',
            'link' => 'required|string|unique:pages'
        ]);

        if (!$validator->fails()) {
            $page = new Page;
            $page->name = $request->name;
            $page->title = $request->title;
            $page->type = $request->type;
            $page->parent_layout = ($request->layout > 0) ? $request->layout : null;
            $page->link = $request->link;
            $page->active = (isset($request->active)) ? true : false;
            $page->description = $request->description;
            $page->main = false;
            $page->user_page = false;
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
            'page' => 'required|integer',
            'name' => 'required|string|max:255',
            'title' => 'required|string',
            'type' => 'required|string|in:F,B',
            'layout' => 'required|integer',
            'description' => 'required|string',
            'link' => 'required|string|unique:pages,link,'.$request->page
        ]);
        if (!$validator->fails()) {
            $page = Page::findOrFail((int)$request->page);
            $page->name = $request->name;
            $page->title = $request->title;
            $page->type = $request->type;
            $page->parent_layout = ($request->layout > 0) ? $request->layout : null;
            $page->link = $request->link;
            $page->active = (isset($request->active)) ? true : false;
            if (isset($request->main_page)) {
                Page::removeMainPage($page->type);
                $page->main = true;
            }
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
    public function loadFrontEnd(Page $page, $option_value = null)
    {
        $type_page = null;

        if (!empty($page)) {
            $type_page = ($page->type == 'F') ? 'front' : 'back';
            if ($page->user_page && Auth::guard($type_page)->user() || !$page->user_page) {
                $result;
                $css;
                $components = $this->setUserCondition(json_decode(json_decode($page->components, true)));

                foreach ($components as $component) {
                    if ($component->type == 'module') {
                        $this->loadModuleComponents($component, $option_value);
                    }
                }

                if (!is_null($page->parent_layout) && $page->parent_layout > 0) {
                    $layout = Layout::findOrFail($page->parent_layout);
                    $parent_components = json_decode(json_decode($layout->components, true));
                    $this->setLayout($parent_components, $components);
                    $css = $layout->css.' '.$page->css;
                    $result = $parent_components;
                }else{
                    $result = $components;
                    $css = $page->css;
                }

                return view('index', [
                    'page' => $page,
                    'components' => $result,
                    'css' => $css,
                    'template' => 'css/bootstrap-new.css'
                ]);
            }
        }

        return redirect(Page::getMainPage($type_page));

    }


    public function loadModuleComponents($component = null, $option_value = null)
    {
        if (!is_null($component)) {
            $className = 'Modules\\'.$component->module.'\\'.$component->module;
            $module = new $className;
            if (isset($component->sentence) && !is_null($component->sentence)) {
                $module->executeSentence($component, $component->sentence, $option_value);
            }elseif(!empty($component->components)){
                $this->setSentences($component->components, $module, $option_value);
            }
            if (!is_null($module->has_variable) && $module->has_variable) {
                $variables = $module->getVariable();
                if (!empty($variables)) {
                    $this->setVariable($component->components, $variables, $option_value);
                }
            }
        }
    }


    public function setVariable($components, $variables, $option_value = null)
    {
        foreach ($components as $component) {
            if ($component->type == 'variable') {
                $value = str_replace(['$', '{', '}'], '', $component->content);
                $component->content = $variables[$value];
            }
            if (!empty($component->components)) {
                $this->setVariable($component->components, $variables, $option_value);
            }
        }
    }

    public function setLayout($components, $child)
    {
        foreach ($components as $component) {
            if ($component->type == 'module') {
                if ($component->module == 'Forum') {
                    dd($components);
                }
                $this->loadModuleComponents($component);
            }

            if (!empty($component->components)) {
                $this->setLayout($component->components, $child);
            }

            if ($component->type == 'childContainer') {
                $component->content = '';
                $component->components = array();
                foreach ($child as $value) {
                   $child_component = Page::cloneComponent($value);
                   array_push($component->components, $child_component);
                }
            }
        }
    }

    public function setSentences($components, $module, $option_value)
    {
        foreach ($components as $component) {
            if (isset($component->sentence) && !is_null($component->sentence)) {
                $module->executeSentence($component, $component->sentence);
            }
        
            if (!empty($component->components)) {
                $this->setSentences($component->components, $module, $option_value);
            }
        }
    }

    public function setUserCondition($components){
        if (!is_null($components) && !empty($components)) {
            foreach ($components as $key => $component) {
                if (isset($component->requiredUserLogin) && !is_null($component->requiredUserLogin) && $component->requiredUserLogin && !Auth::guard("front")->user()) {

                    unset($components[$key]);
                }elseif (!empty($component->components)) {
                    $component->components = $this->setUserCondition($component->components);
                }
            }
        }

        return $components;
    }

}
