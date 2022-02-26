<?php

namespace Modules\Social\Models;

trait Attachable
{
    /**
     * Get the model's comments
     */
    public function attachments() {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}