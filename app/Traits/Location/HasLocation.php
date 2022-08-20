<?php

namespace App\Traits\Location;

use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasLocation
{
    /**
     * @psalm-return \Illuminate\Database\Eloquent\Relations\MorphOne<\App\Models\Location>
     */
    public function location(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Location::class, 'model');
    }

    public function getLocationShortAttribute()
    {
        return $this->location()?->first()?->name;
    }

    public function getLocationAttribute()
    {
        return $this->location()?->first()?->full;
    }
}
