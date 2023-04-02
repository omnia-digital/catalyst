<?php

namespace Modules\Social\Observers;

use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @return void
     */
    public function created(Post $post)
    {
        if ($post->type == PostType::ARTICLE) {
            $post->attachTags(['article']);
        } elseif ($post->type == PostType::RESOURCE) {
            $post->attachTags(['resource']);
        }

        $post->published_at = now();

        $post->save();
    }

    /**
     * Handle the Post "updated" event.
     *
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
