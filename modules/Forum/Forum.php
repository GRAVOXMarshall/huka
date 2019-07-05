<?php

namespace Modules\Forum;

use App\Http\Classes\Module;
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
            $table->string('content');
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

    
    public function executeSentence($component, $sentence)
    {
        if (!is_null($component) && !is_null($sentence)) {
            switch ($sentence->type) {
                case 'if':
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
                                $new_component = $base_component;
                                $this->setVariablesToTopic($topic, $columns, $new_component);
                                foreach ($new_component as $value) {
                                    array_push($component->components, $value);
                                }
                                
                            }

                            break;
                        
                        default:
                            # code...
                            break;
                    }
                break;

                default:
                    # code...
                    break;
            }
        }
    }


    public function setVariablesToTopic($topic, $variables, $components){
        foreach ($components as $component) {
            if ($component->type == 'variable') {
                $value = str_replace(['$', '{', '}'], '', $component->content);
                if (in_array($value, $variables)) {
                    $component->content = $topic->$value;
                }
            }

            if ($component->type == 'link' && isset($component->attributes->reference) && $component->attributes->reference == 'topic') {
                $component->attributes->href = route('view.page', ['page' => 1]);
            }

            if (!empty($component->components)) {
                $this->setVariablesToTopic($topic, $variables, $component->components);
            }
        }
    }

}
