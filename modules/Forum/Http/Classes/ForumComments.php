<?php

namespace Modules\Forum\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class ForumComments extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forum_comments';

    protected $fillable = ['title', 'comments'];

}
