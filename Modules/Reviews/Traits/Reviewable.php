<?php

namespace Modules\Reviews\Traits;

use Modules\Reviews\Models\Review;

trait Reviewable
{
    
    /**
     * Get the model's reviews
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

}
