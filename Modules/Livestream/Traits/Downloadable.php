<?php

namespace App\Traits;

use App\Models\Download;

trait Downloadable
{
    
    /**
     * Get the model's reviews
     */
    public function downloads()
    {
        return $this->morphMany(Download::class, 'downloadable');
    }

    public function totalCount()
    {
        return $this->downloads()->sum('count');
    }

}
