<?php

namespace Modules\Social\Models;

trait Postable
{
    /**
     * Get the model's comments
     */
    public function replies() {
        return $this->morphMany(Post::class, 'postable');
    }

    /**
     * Handles creating the comment of the current model
     */
    public function reply($data, $userID) {
        return $this->replies()->create([
            'user_id' => $userID,
            'body' => $data['body'],
        ]);
    }
}