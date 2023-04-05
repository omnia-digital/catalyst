<?php

namespace Modules\Social\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Social\Events\LikedModel;
use Modules\Social\Events\LikedUserPost;
use Modules\Social\Events\PostWasLiked;
use Modules\Social\Models\Like;
use Modules\Social\Models\Post;

use function auth;

trait Likable
{
    /**
     * Get the model's likes
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likable');
    }

    /**
     * Check if the current model is liked by the user that is logged in
     */
    public function getIsLikedAttribute(): bool
    {
        return (bool) $this->likes()->where('user_id', auth()->id())->where('liked', true)->count();
    }

    /**
     * Check if the current model was previously liked by the user that is logged in
     */
    public function getWasLikedAttribute(): bool
    {
        return (bool) $this->likes()->withTrashed()->where('user_id', auth()->id())->where('liked', true)->whereNotNull('deleted_at')->count();
    }

    /**
     * Check if the current model is disliked by the user that is logged in
     */
    public function getIsDislikedAttribute(): bool
    {
        return (bool) $this->likes()->where('user_id', auth()->id())->where('liked', false)->count();
    }

    /**
     * Check if the current model was previously diliked by the user that is logged in
     */
    public function getWasDislikedAttribute(): bool
    {
        return (bool) $this->likes()->withTrashed()->where('user_id', auth()->id())->where('liked', false)->whereNotNull('deleted_at')->count();
    }

    /**
     * Check if the current model was previously liked or diliked by the user that is logged in
     */
    public function getWasLikedOrDislikedAttribute(): bool
    {
        return (bool) $this->likes()->withTrashed()->where('user_id', auth()->id())->whereNotNull('deleted_at')->count();
    }

    /**
     * Return the total number of likes the current model has
     */
    public function likesCount(): int
    {
        return $this->likes()->where('liked', true)->count();
    }

    /**
     * Return the total number of dislikes the current model has
     */
    public function dislikesCount(): int
    {
        return $this->likes()->where('liked', false)->count();
    }

    /**
     * Handles the like functionality of the current model
     */
    public function like(): void
    {
        if ($this->isLiked) {
            // If the current model is liked by the user then remove the like
            $this->likes()->where('user_id', auth()->id())->where('liked', true)->delete();
        } elseif ($this->wasLikedOrDisliked) {
            // Else if the current model was previously liked by the user then restore the like
            $this->likes()->withTrashed()->where('user_id', auth()->id())->restore();
            $this->likes()->withTrashed()->where('user_id', auth()->id())->update(['liked' => true]);
        } else {
            // Else if the current model was never liked by the user, then create/update the like
            $this->likes()->updateOrCreate(
                ['user_id' => auth()->id()],
                ['liked' => true]
            );

            
            LikedModel::dispatch(auth()->user(), $this);
        }
    }

    /**
     * Handles the dislike functionality of the current model
     */
    public function dislike(): void
    {
        if ($this->isDisliked) {
            // If the current model is disliked by the user then remove the like
            $this->likes()->where('user_id', auth()->id())->where('liked', false)->delete();
        } elseif ($this->wasLikedOrDisliked) {
            // Else if the current model was previously disliked by the user then restore the like
            $this->likes()->withTrashed()->where('user_id', auth()->id())->restore();
            $this->likes()->withTrashed()->where('user_id', auth()->id())->update(['liked' => false]);
        } else {
            // Else if the current model was never disliked by the user, then create/update the like
            $this->likes()->updateOrCreate(
                ['user_id' => auth()->id()],
                ['liked' => false]
            );
        }
    }
}
