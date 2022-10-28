<?php

namespace App\Lenses\Teams;

use App\Lenses\BaseLens;
use Illuminate\Database\Eloquent\Builder;

class PopularIndiesTeamsLens extends BaseLens
{
    public function handle(Builder $query): Builder
    {
        return $query
            ->withCount(['likes'])
            ->withAnyTags(['indie'])
            ->orderBy('likes_count', 'DESC');
    }
}
