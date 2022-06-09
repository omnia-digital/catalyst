<?php

namespace Modules\Social\Traits;

use App\Models\Award;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
