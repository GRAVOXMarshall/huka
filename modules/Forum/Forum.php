<?php

namespace Modules\Forum;

use App\Http\Classes\Module;
use App\Http\Classes\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Classes\ModuleConfigure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Forum\Http\Classes\ForumComments;
use Modules\Forum\Http\Classes\ForumTopics;

class Forum extends Module
{

    public function __construct() {

        $this->name = 'Forum';

        $this->description = 'Corum Module';

        //$this->parent = 'Authentication';
        
        //$this->has_variable = true;
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

        parent::updateConfiguration($this->name, 'List of topics', 'Select where you want to add the list of topics', 'select-page', 2);

        parent::updateConfiguration($this->name, 'Design list of topics', 'Customize design of the list of topics', 'design-page', 3);

        parent::updateConfiguration($this->name, 'Form to add topic', 'Select where you want to add the form topic', 'select-page', 4);

        parent::updateConfiguration($this->name, 'Design form to add topic', 'Customize design of the form to add topic', 'design-page', 5);

        parent::updateConfiguration($this->name, 'View of topic', 'Select where you want to add the view of topic', 'select-page', 6);

        parent::updateConfiguration($this->name, 'Design view of topic', 'Customize design of the view of topic', 'design-page', 7);

        /** 
            Code for create and delete a table in database
        **/
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        if(Schema::hasTable('forum_topics')){
            Schema::dropIfExists('forum_topics'); 
        }

        if(Schema::hasTable('forum_comments')){
            Schema::dropIfExists('forum_comments'); 
        }

        Schema::create('forum_topics', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->string('content');
            $table->timestamps();
        });

        Schema::create('forum_comments', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('topic_id');
            $table->foreign('topic_id')->references('id')->on('forum_topics')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('comment');
            $table->timestamps();
        });
            
      

        if (empty($this->error)) {
            return true;
        }

        return false;
    }

    public function uninstall()
    {

        //Schema::drop('forum_comments'); 

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

    
    public function executeSentence($component, $sentence, $option_value = null)
    {
        if (!is_null($component) && !is_null($sentence)) {
            switch ($sentence->type) {
                case 'if':
                    switch ($sentence->option) {
                        case 'issetTopic':
                            if (!is_null($option_value)) {
                                $topic = ForumTopics::findOrFail((int)$option_value);
                                if (!is_null($module = $this->getByName($this->name))) {
                                    $configuration = ModuleConfigure::where('module_id', $module->id)
                                                    ->where('step', 1)
                                                    ->firstOrFail();
                                    $values = json_decode($configuration->value);
                                    foreach ($component->components as $value) {
                                        $this->setVariablesToTopic($topic, $values->topics, $value);
                                    }
                                }    
                            }else{
                                //$component->components = array();
                            }             
                            break;
                    }
                    /*
                    if(eval('return '.$sentence->value.';')){
                        $data = $component->components[0];
                        $component->components = array();
                        switch ($sentence->option) {
                            case 'testingMode':     
                                $forum_comments = ForumComments::all();
                                    
                                foreach ($forum_comments as $values) {
                                    $new_component = $data;
                                    foreach ($new_component->components[1]->components[0]->components[0]->components as $value) {
                                      if ($value->type == "variable") {
                                        $str = str_replace(['$', '{', '}'], '', $value->content);
                                        if ($str == "title") {
                                           $value->content = $values->title;
                                        }
                                        array_push($component->components, $new_component);
                                         
                                      }
                                       
                                    }
                                }      

                                break;
                            
                            default:
                                # code...
                                break;
                        }
                    }
                    */
                    
                break;
                
                case 'foreach':
                    switch ($sentence->option) {
                        case 'topics':
                            $base_component = $component->components;

                            $component->components = array();

                            $forum_topics = DB::table('users')
                                            ->join('forum_topics', 'users.id', '=', 'forum_topics.user_id')
                                            ->get();

                            $columns = array();
                            $topics = DB::select('SHOW COLUMNS FROM forum_topics');
                            $users = DB::select('SHOW COLUMNS FROM users');

                            foreach ($topics as $value) {
                                if (!in_array($value, $columns)) {
                                    array_push($columns, $value->Field);
                                }
                            }

                            foreach ($users as $value) {
                                if (!in_array($value, $columns)) {
                                    array_push($columns, $value->Field);
                                }
                            }

                            foreach ($forum_topics as $topic) {
                                foreach ($base_component as $value) {
                                    $new_component = Page::cloneComponent($value);
                                    $this->setVariablesToTopic($topic, $columns, $new_component);
                                    array_push($component->components, $new_component);
                                }
                                
                            }

                            break;
                        
                        case 'comments':
                            if (!is_null($option_value) && !is_null($module = $this->getByName($this->name))) {

                                $base_component = $component->components;

                                $component->components = array();

                                $comments = DB::table('forum_comments')
                                            ->join('users', 'users.id', '=', 'forum_comments.user_id')
                                            ->where('topic_id', '=', $option_value)
                                            ->get();

                                $columns = array();
                                $configuration = ModuleConfigure::where('module_id', $module->id)
                                                ->where('step', 1)
                                                ->firstOrFail();
                                $values = json_decode($configuration->value);

                                foreach ($values->users as $value) {
                                    if (!in_array($value, $columns)) {
                                        array_push($columns, $value);
                                    }
                                }

                                foreach ($values->comments as $value) {
                                    if (!in_array($value, $columns)) {
                                        array_push($columns, $value);
                                    }
                                }

                                foreach ($comments as $comment) {
                                    foreach ($base_component as $value) {
                                        $new_component = Page::cloneComponent($value);
                                        $this->setVariablesToComment($comment, $columns, $new_component);
                                        array_push($component->components, $new_component);
                                    }
                                }

                            }
                            
                        break;

                    }
                break;

                default:
                    # code...
                    break;
            }

            if (isset($component->components) && !empty($component->components) && count($component->components) > 0) {
                foreach ($component->components as $component) {
                    if (isset($component->sentence) && !is_null($component->sentence)) {
                        $this->executeSentence($component, $component->sentence, $option_value);
                    }                    
                }
            }

        }
    }


    public function setVariablesToTopic($topic, $variables, $component){
        if ($component->type == 'variable') {
            $value = str_replace(['$', '{', '}'], '', $component->content);
            if (in_array($value, $variables)) {
                $component->content = $topic->$value;
            }
        }

        if (!empty($component->components)) {
            foreach ($component->components as $value) {
                $this->setVariablesToTopic($topic, $variables, $value);
            }
        }

        if ($component->type == 'link' && isset($component->attributes->reference) && $component->attributes->reference == 'topic' && !is_null($module = $this->getByName($this->name))) {

            $configuration = ModuleConfigure::where('module_id', $module->id)
                            ->where('step', 6)
                            ->firstOrFail();
            $id_page = json_decode($configuration->value)->page;
            $component->attributes->href = route('view.page', ['page' => $id_page, 'value' => $topic->id]);
        }

        if ($component->type == 'input' && isset($component->attributes->reference) && $component->attributes->reference == 'topic') {
            $component->attributes->value = $topic->id;
        }

    }

    public function setVariablesToComment($comment, $variables, $component){
        if ($component->type == 'variable') {
            $value = str_replace(['$', '{', '}'], '', $component->content);
            if (in_array($value, $variables)) {
                $component->content = $comment->$value;
            }
        }

        if (!empty($component->components)) {
            foreach ($component->components as $value) {
                $this->setVariablesToComment($comment, $variables, $value);
            }
        }
    }

}
