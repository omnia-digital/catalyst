<?php

namespace App\Actions\Teams;

use App\Models\Team;
use Illuminate\Support\Collection;

class GetTrendingTeamsAction
{
    public function execute(int $limit = 5): array|Collection
    {
        return visits(Team::class)->top($limit);
    }
}
