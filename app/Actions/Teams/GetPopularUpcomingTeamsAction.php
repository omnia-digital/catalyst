<?php

namespace App\Actions\Teams;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class GetPopularUpcomingTeamsAction
{
    public function execute(int $limit = 5): Collection
    {
        return Team::query()
            ->limit($limit)
            ->withCount(['likes', 'users as members'])
            ->whereBetween('start_date', [now()->addDays(7), now()])
            ->orderBy('likes_count', 'DESC')
            ->get();
    }
}
