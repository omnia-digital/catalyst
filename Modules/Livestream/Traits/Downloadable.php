<?php

namespace Modules\Livestream\Traits;

use Modules\Livestream\Models\Download;

trait Downloadable
{
    public function totalCount()
    {
        return $this->downloads()->sum('count');
    }

    /**
     * Get the model's reviews
     */
    public function downloads()
    {
        return $this->morphMany(Download::class, 'downloadable');
    }
}
