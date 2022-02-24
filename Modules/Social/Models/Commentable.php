<?php

namespace Modules\Social\Models;

trait Commentable
{
    /**
     * Get the model's comments
     */
    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Handles creating the comment of the current model
     */
    public function comment($data, $userID, $parentID = null) {
        return $this->comments()->create([
            'user_id' => $userID,
            'parent_id' => $parentID,
            'body' => $data['body'],
        ]);
    }
}