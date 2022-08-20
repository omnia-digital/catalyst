<?php

namespace Modules\Games\Http\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;
use MarcReichel\IGDBLaravel\Models\Cover;
use Modules\Games\Models\Game;

class RecentlyReviewed extends Component
{
    public array $recentlyReviewed = [];

    private function formatForView($games): array
    {

        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                $coverUrl = $game->cover_url,
                'coverImageUrl' => $game->cover_url,
                'rating' => isset($game['rating']) ? round($game['rating']) : null,
                'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            ]);
        })->toArray();
    }
}
