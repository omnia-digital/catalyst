<?php

namespace App\Lenses\Teams;

use App\Lenses\BaseLens;
use Illuminate\Database\Eloquent\Builder;

class PopularUpcomingTeamsLens extends BaseLens
{
    /**
     * @return Builder
     *
     * @psalm-return Builder<\Illuminate\Database\Eloquent\Model>
     */
    public function handle(Builder $query): Builder
    {
        return $query
            ->withCount(['likes'])
            ->whereBetween('start_date', [now()->addDays(7), now()])
            ->orderBy('likes_count', 'DESC');
    }
}
