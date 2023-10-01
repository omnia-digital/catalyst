<?php

namespace App\Traits\Location;

use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasLocation
{
    public function getLocationShortAttribute()
    {
        return $this->location()?->first()?->name;
    }

    public function location(): MorphOne
    {
        return $this->morphOne(Location::class, 'model');
    }

    public function getLocationAttribute()
    {
        return $this->location()?->first()?->full;
    }
}
