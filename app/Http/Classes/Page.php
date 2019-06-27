<?php

namespace App\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

    protected $fillable = ['name', 'title', 'description', 'link', 'type', 'active', 'main', 'user_page'];

    public static function removeMainPage($type = 'F')
    {
    	$page = parent::where('type', '=', $type)->firstOrFail();
    	$page->main = false;
    	$page->save();
    }

    public static function getMainPage($type = null)
    {
        if (is_null($type)) {
            $type = 'front';
        }

        $type_query = ($type == 'front') ? 'F' : 'B';

        $page = parent::where('main', '=', true)
                    ->where('type', '=', $type_query)
                    ->firstOrFail();

        return route('view.page', ['page' => $page->id]);

    }
}
