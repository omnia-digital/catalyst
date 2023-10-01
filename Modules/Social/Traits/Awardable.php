<?php

namespace Modules\Social\Traits;

use App\Models\Award;

trait Awardable
{
    /**
     * Get the model's awards
     */
    public function awards()
    {
        return $this->morphToMany(Award::class, 'awardable');
    }
}
