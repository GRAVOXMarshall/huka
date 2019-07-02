<?php

namespace Modules\Forum;

use App\Http\Classes\Module;
use Illuminate\Support\Facades\Auth;
use App\Http\Classes\ModuleConfigure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Forum\Http\Classes\ForumComments;

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
        parent::updateConfiguration($this->name, 'Home', 'Home View', 'home-view', 1);

        parent::updateConfiguration($this->name, 'Comments View', 'Comments View', 'select-page', 2);

        parent::updateConfiguration($this->name, 'Comment View Layout', 'Comment View Layout', 'design-page', 3);

        parent::updateConfiguration($this->name, 'Comment Creation View', 'Comment Creation View', 'select-page', 4);

        parent::updateConfiguration($this->name, 'Comment Creation View Design', 'Comment Creation View Design', 'design-page', 5);

        /** 
            Code for create and delete a table in database
        **/
        if(Schema::hasTable('forum_comments')){
            Schema::dropIfExists('forum_comments'); 
        } 
            Schema::create('forum_comments', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('title');
                $table->string('comments');
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

                               // dd($component->components);      

                                break;
                            
                            default:
                                # code...
                                break;
                        }
                    }
                    
                    break;
                
                default:
                    # code...
                    break;
            }
        }
    }
}
