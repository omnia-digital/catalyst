<?php

namespace App\Lenses\Teams;

use App\Lenses\BaseLens;
use Illuminate\Database\Eloquent\Builder;

class UpcomingTeamsLens extends BaseLens
{
    public function handle(Builder $query): Builder
    {
        return $query->whereBetween('start_date', [now()->addDays(7), now()]);
    }
}
