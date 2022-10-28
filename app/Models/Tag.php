<?php

namespace App\Models;

use Modules\Social\Models\Post;

class Tag extends \Spatie\Tags\Tag
{
    public CONST TAG_REGEX = '/(?<![\S])#([a-z0-9_-]+)/';

    public static function pullTags($text)
    {
        $hashtags = array();

        preg_match_all(Tag::TAG_REGEX, $text, $hashtags);

        return $hashtags[1];
    }

    public static function getTags($hashtags)
    {
        $tags = array();

        foreach ($hashtags as $hashtag) {
            $tags[] = Tag::findOrCreateFromString($hashtag);
        }

        return $tags;
    }

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
