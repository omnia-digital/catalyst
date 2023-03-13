<?php

namespace App\Models;

use Modules\Jobs\Support\HasJobs;
use Modules\Social\Models\Post;

class Tag extends \Spatie\Tags\Tag
{
    use HasJobs;
    public CONST TAG_REGEX = '/(?<![\S])#([a-z0-9_-]+)/';

    public static function parseHashTagsFromString($text)
    {
        $hashtags = array();

        preg_match_all(Tag::TAG_REGEX, $text, $hashtags);

        return $hashtags[1];
    }

    public static function findOrCreateTags($hashtags, $type = '')
    {
        $tags = array();

        foreach ($hashtags as $hashtag) {
            $tags[] = Tag::findOrCreateFromString($hashtag, $type);
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
