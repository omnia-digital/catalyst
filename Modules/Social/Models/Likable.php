<?php

namespace Modules\Social\Models;

use Illuminate\Database\Eloquent\Builder;

trait Likable
{
    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function getIsLikedAttribute() {
        return (bool) $this->likes()->where('user_id', auth()->id())->where('liked', true)->count();
    }

    public function getWasLikedAttribute() {
        return (bool) $this->likes()->withTrashed()->where('user_id', auth()->id())->where('liked', true)->whereNotNull('deleted_at')->count();
    }

    public function getIsDislikedAttribute() {
        return (bool) $this->likes()->where('user_id', auth()->id())->where('liked', false)->count();
    }

    public function getWasDislikedAttribute() {
        return (bool) $this->likes()->withTrashed()->where('user_id', auth()->id())->where('liked', false)->whereNotNull('deleted_at')->count();
    }

    public function likesCount() {
        return $this->likes()->where('liked', 1)->count();
    }

    public function like() {
        if ($this->isLiked) {
            $this->likes()->delete();

        } else if ($this->wasLiked) {
            $this->likes()->restore();

        } else {
            $this->likes()->updateOrCreate(
                ['user_id' => auth()->id()],
                ['liked' => true]
            );

        }
        
    }

    public function dislike() {
        if ($this->isDisliked) {
            $this->likes()->delete();

        } else if ($this->wasDisliked) {
            $this->likes()->restore();

        } else {
            $this->likes()->updateOrCreate(
                ['user_id' => auth()->id()],
                ['liked' => false]
            );

        }
        
    }
}
