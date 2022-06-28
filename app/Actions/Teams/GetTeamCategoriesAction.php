<?php

namespace App\Actions\Teams;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class GetTeamCategoriesAction
{
    public function execute(): array
    {
        return [
            'New Releases',
            'Specials',
            'Indies',
            'By User Tags',
            'Upcoming',
            'Popular Locations',
        ];
    }
}
