<?php

namespace Modules\Social\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Social\Models\Post;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Post $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return $user->is($post->user);
    }
}
