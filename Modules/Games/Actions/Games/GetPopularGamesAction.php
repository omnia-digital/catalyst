<?php

namespace Modules\Games\Actions\Games;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\Games\Models\IGDB\Game as IGDBGame;

class GetPopularGamesAction
{
    public function execute(int $limit = 5): Collection
    {
        $before = Carbon::now()->subMonths(2)->timestamp;
        $after = Carbon::now()->addMonths(2)->timestamp;

        $popularGamesUnformatted = IGDBGame::where('first_release_date', '>', $before)->where('first_release_date', '<', $after)->get();

//        $popularGames = $popularGamesUnformatted;
        return $popularGamesUnformatted;

        return $this->formatForView($popularGamesUnformatted);

        return collect($popularGames)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->dispatch('gameWithRatingAdded', [
                'coverImageUrl' => $game['coverImageUrl'],
                'slug' => $game['slug'],
                'rating' => $game['rating'] / 100,
            ]);
        });
    }

    private function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => $game->cover_url,
                'rating' => isset($game['rating']) ? round($game['rating']) : null,
                'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            ]);
        });
    }
}
