<?php

namespace Modules\Forum\Http\Classes;

use Illuminate\Database\Eloquent\Model;

class ForumTopics extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forum_topics';

    protected $fillable = ['user_id', 'title', 'content'];

}
