<?php

namespace App\Models;

use Modules\Social\Models\Post;

class Tag extends \Spatie\Tags\Tag
{
    public CONST TAG_REGEX = '/(?<![\S])#([a-z0-9_-]+)/';

    public function taggable()
    {
        return $this->morphTo();
    }

    public function teams()
    {
        return $this->morphedByMany(Team::class, 'taggable');
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
