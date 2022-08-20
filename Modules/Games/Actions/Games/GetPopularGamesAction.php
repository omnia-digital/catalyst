<?php

namespace Modules\Games\Actions\Games;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use MarcReichel\IGDBLaravel\Models\Cover;
use Modules\Games\Models\Game;

class GetPopularGamesAction
{
    public function execute(int $limit = 5): Collection
    {
        $before = Carbon::now()->subMonths(2)->timestamp;
        $after  = Carbon::now()->addMonths(2)->timestamp;

        $popularGamesUnformatted = Game::where('first_release_date', '>', $before)->where('first_release_date', '<', $after)->get();

//        $popularGames = $popularGamesUnformatted;
        return $popularGamesUnformatted;
        return $this->formatForView($popularGamesUnformatted);

        return collect($popularGames)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->emit('gameWithRatingAdded', [
                'slug'   => $game['slug'],
                'rating' => $game['rating'] / 100
            ]);
        });
    }

}
