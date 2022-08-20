<?php

namespace Modules\Games\Http\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Games\Models\Game;

class ComingSoon extends Component
{


    private function formatForView($games): array
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => $game->cover_url,
                'releaseDate' => Carbon::parse($game['first_release_date'])->format('M d, Y'),
            ]);
        })->toArray();
    }
}
