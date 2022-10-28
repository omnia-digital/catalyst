<?php

namespace App\Providers;

use App\Lenses\Teams\ByUserTagTeamsLens;
use App\Lenses\Teams\IndiesTeamsLens;
use App\Lenses\Teams\NewReleaseTeamsLens;
use App\Lenses\Teams\PopularIndiesTeamsLens;
use App\Lenses\Teams\PopularLocationTeamsLens;
use App\Lenses\Teams\PopularUpcomingTeamsLens;
use App\Lenses\Teams\SpecialTeamsLens;
use App\Lenses\Teams\UpcomingTeamsLens;

class TeamLensesServiceProvider extends LensesServiceProvider
{
    public function register()
    {
        $this
            ->registerLens('new-releases', NewReleaseTeamsLens::class)
            ->registerLens('by-user-tags', ByUserTagTeamsLens::class)
            ->registerLens('popular-locations', PopularLocationTeamsLens::class)
            ->registerLens('specials', SpecialTeamsLens::class)
            ->registerLens('upcoming', UpcomingTeamsLens::class)
            ->registerLens('popular-upcoming', PopularUpcomingTeamsLens::class)
            ->registerLens('popular-indies', PopularIndiesTeamsLens::class)
            ->registerLens('indies', IndiesTeamsLens::class);
    }
}
