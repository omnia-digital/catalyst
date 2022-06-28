<?php

namespace App\Actions\Teams;

use App\Models\Team;

class GetTrendingTeamsAction
{
    public function execute(int $limit = 5): array|\Illuminate\Support\Collection
    {
        return visits(Team::class)->top($limit);
    }
}
