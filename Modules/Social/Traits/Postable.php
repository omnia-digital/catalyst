<?php

namespace Modules\Social\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Social\Models\Post;

trait Postable
{
    /**
     * Get the posts for the current model
     */
    public function posts(): MorphMany
    {
        // @NOTE - we have to remove the 'parent' globalscope in order to retrieve comments
        return $this->morphMany(Post::class, 'postable')
            ->withoutGlobalScope('parent');
    }

    /**
     * Handles creating the post for the current model
     */
    public function createPost($data, $userId): Model|Post
    {
        return $this->posts()->create([
            'user_id' => $userId,
            'body' => $data['body'],
        ]);
    }

    //** Aliases **//
    /**
     * Alias for posts()
     */
    public function comments(): MorphMany
    {
        return $this->posts();
    }

    /**
     * Alias for createPost()
     */
    public function createComment($data, $userId): Model|Post
    {
        return $this->createPost($data, $userId);
    }
}
