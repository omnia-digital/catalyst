<?php

namespace Modules\Social\Models;

trait Likable
{
    
    /**
     * Get the model's likes
     */
    public function likes() {
        return $this->morphMany(Like::class, 'likable');
    }

    /**
     * Check if the current model is liked by the user that is logged in
     */
    public function getIsLikedAttribute() {
        return (bool) $this->likes()->where('user_id', auth()->id())->where('liked', true)->count();
    }

    /**
     * Check if the current model was previously liked by the user that is logged in
     */
    public function getWasLikedAttribute() {
        return (bool) $this->likes()->withTrashed()->where('user_id', auth()->id())->where('liked', true)->whereNotNull('deleted_at')->count();
    }

    /**
     * Check if the current model is disliked by the user that is logged in
     */
    public function getIsDislikedAttribute() {
        return (bool) $this->likes()->where('user_id', auth()->id())->where('liked', false)->count();
    }

    /**
     * Check if the current model was previously diliked by the user that is logged in
     */
    public function getWasDislikedAttribute() {
        return (bool) $this->likes()->withTrashed()->where('user_id', auth()->id())->where('liked', false)->whereNotNull('deleted_at')->count();
    }

    /**
     * Return the total number of likes the current model has
     */
    public function likesCount() {
        return $this->likes()->where('liked', true)->count();
    }

    /**
     * Return the total number of dislikes the current model has
     */
    public function dislikesCount() {
        return $this->likes()->where('liked', false)->count();
    }

    /**
     * Handles the like functionality of the current model
     */
    public function like() {
        if ($this->isLiked) {
            // If the current model is liked by the user then remove the like
            $this->likes()->where('user_id', auth()->id())->where('liked', true)->delete();

        } else if ($this->wasLiked) {
            // Else if the current model was previously liked by the user then restore the like
            $this->likes()->withTrashed()->where('user_id', auth()->id())->where('liked', true)->restore();

        } else {
            // Else if the current model was never liked by the user, then create/update the like
            $this->likes()->updateOrCreate(
                ['user_id' => auth()->id()],
                ['liked' => true]
            );

        }
        
    }

    /**
     * Handles the dislike functionality of the current model
     */
    public function dislike() {
        if ($this->isDisliked) {
            // If the current model is disliked by the user then remove the like
            $this->likes()->where('user_id', auth()->id())->where('liked', false)->delete();

        } else if ($this->wasDisliked) {
            // Else if the current model was previously disliked by the user then restore the like
            $this->likes()->withTrashed()->where('user_id', auth()->id())->where('liked', false)->restore();

        } else {
            // Else if the current model was never disliked by the user, then create/update the like
            $this->likes()->updateOrCreate(
                ['user_id' => auth()->id()],
                ['liked' => false]
            );

        }
        
    }
}
