<?php

namespace Modules\Social\Models;

trait Postable
{
    /**
     * Get the replies for the current model
     */
    public function replies() {
        return $this->morphMany(Post::class, 'postable');
    }

    /**
     * Handles creating the reply for the current model
     */
    public function reply($data, $userID) {
        return $this->replies()->create([
            'user_id' => $userID,
            'body' => $data['body'],
        ]);
    }
}