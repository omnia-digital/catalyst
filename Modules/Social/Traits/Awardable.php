<?php

namespace Modules\Social\Traits;

use App\Models\Award;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Awardable
{
    
    /**
     * Get the model's awards
     *
     * @psalm-return \Illuminate\Database\Eloquent\Relations\MorphToMany<\App\Models\Award>
     */
    public function awards(): \Illuminate\Database\Eloquent\Relations\MorphToMany
    {
        return $this->morphToMany(Award::class, 'awardable');
    }

}
