<?php

namespace App\Actions\Teams;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class GetTeamCategoriesAction
{
    /**
     * @return string[]
     *
     * @psalm-return array{0: 'New Releases', 1: 'Specials', 2: 'Indies', 3: 'By User Tags', 4: 'Upcoming', 5: 'Popular Locations'}
     */
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
