<?php

namespace Modules\Games\Actions\Games;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Modules\Games\Models\Game;

class GetRecentlyReviewedGamesAction
{
    public function execute(int $limit = 5): Collection
    {
        $before = Carbon::now()
            ->subMonths(2)->timestamp;
        $current = Carbon::now()->timestamp;

        $recentlyReviewedUnformatted = Game::where('first_release_date', '>', $before)
            ->where('first_release_date', '<', $current)
            ->get();
        //         $recentlyReviewedUnformatted = Http::withHeaders(config('services.igdb'))
        //            ->withOptions([
        //                'body' => "
        //                    fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count, summary, slug;
        //                    where platforms = (48,49,130,6)
        //                    & (first_release_date >= {$before}
        //                    & first_release_date < {$current}
        //                    & rating_count > 5);
        //                    sort popularity desc;
        //                    limit 3;
        //                "
        //            ])->get('https://api-v3.igdb.com/games')
        //            ->json();

        $this->recentlyReviewed = $this->formatForView($recentlyReviewedUnformatted);
        //        $this->recentlyReviewed = $recentlyReviewedUnformatted;

        collect($this->recentlyReviewed)
            ->filter(function ($game) {
                return $game['rating'];
            })
            ->each(function ($game) {
                $this->dispatch('reviewGameWithRatingAdded', [
                    'slug' => 'review_' . $game['slug'],
                    'rating' => $game['rating'] / 100,
                ]);
            });
    }

    private function formatForView($games)
    {
        return collect($games)
            ->map(function ($game) {
                return collect($game)->merge([
                    'coverUrl' => $game->cover_url,
                    'coverImageUrl' => $game->cover_url,
                    'rating' => isset($game['rating']) ? round($game['rating']) : null,
                    'platforms' => collect($game['platforms'])
                        ->pluck('abbreviation')
                        ->implode(', '),
                ]);
            })
            ->toArray();
    }
}
