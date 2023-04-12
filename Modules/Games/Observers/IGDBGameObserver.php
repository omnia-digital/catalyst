<?php

namespace Modules\Games\Observers;

use Modules\Games\Models\IGDB\Game as IGDBGame;

class IGDBGameObserver
{
    public function retrieved(IGDBGame $game)
    {
        dd('retrieved');
    }
}
