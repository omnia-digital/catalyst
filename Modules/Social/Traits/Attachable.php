<?php

namespace Modules\Social\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Attachable
{
    /**
     * Get the model's attachments
     *
     * @psalm-return \Illuminate\Database\Eloquent\Relations\MorphMany<Attachment>
     */
    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
