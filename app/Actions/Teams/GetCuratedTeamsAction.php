<?php

namespace App\Actions\Teams;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class GetCuratedTeamsAction
{
    public function execute(int $limit = 5): Collection
    {
        return Team::query()
            ->limit($limit)
            ->withCount('users as members')
            ->withAnyTags(['curated'])
            ->get();
    }
}
