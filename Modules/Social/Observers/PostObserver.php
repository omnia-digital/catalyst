<?php

namespace Modules\Social\Observers;

use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \Modules\Social\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        if ($post->type == PostType::RESOURCE) {
            $post->attachTags(['resource']);
        }


        $post->save();
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \Modules\Social\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \Modules\Social\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     *
     * @param  \Modules\Social\Models\Post  $post
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     *
     * @param  \Modules\Social\Models\Post  $post
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
