<?php

namespace Modules\Social\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Mention extends Model
{
    use HasFactory;

    protected $guarded = [];

    public CONST USER_HANDLE_REGEX = '/(?<![\S])@([a-z0-9_-]+)/';

    public CONST TEAM_HANDLE_REGEX = '/(?<![\S])@{2}([a-z0-9_-]+)/';
    
    protected static function newFactory()
    {
        return \Modules\Social\Database\factories\MentionFactory::new();
    }

    public static function createManyFromHandle($handles, $type, $post)
    {
        foreach ($handles as $handle) {
            Mention::create([
                'mentionable_type' => $type,
                'mentionable_id' => $type::findByHandle($handle)->id,
                'postable_type' => $post::class,
                'postable_id' => $post->id
            ]);
        }
    }

    public function mentionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function postable(): MorphTo
    {
        return $this->morphTo();
    }

    public function poster()
    {
        return $this->hasOneThrough(User::class, Post::class);
    }
}
