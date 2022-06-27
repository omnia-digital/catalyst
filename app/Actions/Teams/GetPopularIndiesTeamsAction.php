<?php

namespace App\Actions\Teams;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class GetPopularIndiesTeamsAction
{
    public function execute(int $limit = 5): Collection
    {
        return Team::query()
            ->limit($limit)
            ->withCount(['likes', 'users as members'])
            ->withAnyTags(['indie'])
            ->orderBy('likes_count', 'DESC')
            ->get();
    }
}
