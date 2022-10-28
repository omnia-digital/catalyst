<?php

namespace App\Lenses\Teams;

use App\Lenses\BaseLens;
use Illuminate\Database\Eloquent\Builder;

class PopularLocationTeamsLens extends BaseLens
{
    public function handle(Builder $query): Builder
    {
        return $query;
    }
}
