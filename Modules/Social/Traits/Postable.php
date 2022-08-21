<?php

namespace Modules\Social\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Social\Models\Post;

trait Postable
{
    /**
     * Get the posts for the current model
     *
     * @psalm-return \Illuminate\Database\Eloquent\Builder<TRelatedModel>
     */
    public function posts(): \Illuminate\Database\Eloquent\Builder
    {
        // @NOTE - we have to remove the 'parent' globalscope in order to retrieve comments
        return $this->morphMany(Post::class, 'postable')
            ->withoutGlobalScope('parent');
    }

    /**
     * Handles creating the post for the current model
     */
    public function createPost($data, $userId): Post
    {
        return $this->posts()->create([
            'user_id' => $userId,
            'body' => $data['body'],
        ]);
    }

    //** Aliases **//
    /**
     * Alias for posts()
     *
     * @psalm-return \Illuminate\Database\Eloquent\Builder<TRelatedModel>
     */
    public function comments(): \Illuminate\Database\Eloquent\Builder
    {
        return $this->posts();
    }

    /**
     * Alias for createPost()
     *
     * @return TRelatedModel|\Modules\Social\Models\Post
     */
    public function createComment($data, $userId): Post
    {
        return $this->createPost($data, $userId);
    }
}
