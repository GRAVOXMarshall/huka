<?php

namespace Modules\Forum\Http\Controllers;

use App\Http\Classes\Page;
use Modules\Forum\Forum;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Classes\ModuleConfigure;
use Illuminate\Auth\Events\Registered;
use Modules\Forum\Http\Classes\ForumTopics;
use Modules\Forum\Http\Classes\ForumComments;

class ForumController extends Controller
{
    public function submitAddTopic(Request $request){
        $user_id = 0;
        if ($user = Auth::guard('front')->user()) {
            $user_id = $user->id;
        }
        $request->request->add(['user_id' => $user_id]);
        $inputs = $this->validateField($request);

        event(new Registered($topic = DB::table('forum_topics')->insert($inputs)));
        $forum = new Forum();

        if (!is_null($module = $forum->getByName($forum->name))) {
            $configuration = ModuleConfigure::where('module_id', $module->id)
                            ->where('step', 2)
                            ->firstOrFail();
            $page = json_decode($configuration->value)->value;
            return redirect(route('view.page', ['page' => $page]));
        }

        return redirect(Page::getMainPage('front'));
    }


    public function submitAddComment(Request $request){
        $user_id = 0;
        if ($user = Auth::guard('front')->user()) {
            $user_id = $user->id;
        }
        $request->request->add(['user_id' => $user_id]);
        $inputs = $this->validateField($request);
        event(new Registered($comment = DB::table('forum_comments')->insert($inputs)));
        $forum = new Forum();

        if (!is_null($module = $forum->getByName($forum->name))) {
            $configuration = ModuleConfigure::where('module_id', $module->id)
                            ->where('step', 2)
                            ->firstOrFail();

            $page = json_decode($configuration->value)->value;
            return redirect(route('view.page', ['page' => $page]));
        }

        return redirect(Page::getMainPage('front'));
    }

    

    /**
     * Validate the user register request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateField(Request $request)
    {
        $inputs = array();
        
        foreach ($request->all() as $key => $value) {
            if ($key != '_token' && $key != 'user_id') {
                $inputs[$key] = 'required|string';
            }elseif ($key == 'user_id') {
                $inputs[$key] = 'required|exists:users,id';
            }
        }
        return $request->validate($inputs);
    }
}
