<?php

namespace App\Models\Traits;

use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasLocation
{
    public function location(): MorphOne
    {
        return $this->morphOne(Location::class, 'model');
    }

    public function getLocationShortAttribute()
    {
        if($this->location) {
            return $this->location->name;
        }

        return null;
    }

    public function getLocationAttribute()
    {
        if($this->location) {
            return $this->location->full;
        }

        return null;
    }
}
