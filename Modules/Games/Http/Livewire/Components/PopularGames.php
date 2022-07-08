<?php

namespace Modules\Games\Http\Livewire\Components;

use App\Models\Game;
use Carbon\Carbon;
use Livewire\Component;
use MarcReichel\IGDBLaravel\Models\Cover;

class PopularGames extends Component
{
    public $popularGames = [];

    public function loadPopularGames()
    {
        $before = Carbon::now()->subMonths(2)->timestamp;
        $after = Carbon::now()->addMonths(2)->timestamp;

        $popularGamesUnformatted = Game::where('first_release_date', '>', $before)
            ->where('first_release_date', '<', $after)
            ->get();
//        $popularGamesUnformatted = Cache::remember('popular-games', 7, function () use ($before, $after) {
//            // sleep(3);
//            return Http::withHeaders(config('services.igdb'))
//                ->withOptions([
//                    'body' => "
//                        fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, slug;
//                        where platforms = (48,49,130,6)
//                        & (first_release_date >= {$before}
//                        & first_release_date < {$after});
//                        sort popularity desc;
//                        limit 12;
//                    "
//                ])->get('https://api-v3.igdb.com/games')
//                ->json();
//        });

        // dd($this->formatForView($popularGamesUnformatted));
        $this->popularGames = $this->formatForView($popularGamesUnformatted);

        collect($this->popularGames)->filter(function ($game) {
            return $game['rating'];
        })->each(function ($game) {
            $this->emit('gameWithRatingAdded', [
                'slug' => $game['slug'],
                'rating' => $game['rating'] / 100
            ]);
        });
    }

    public function render()
    {
        return view('games::livewire.components.popular-games');
    }

    private function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                $coverUrl = Cover::where('id', $game['cover'])->first()?->url,

                'coverImageUrl' => $game->cover_url,
                'rating' => isset($game['rating']) ? round($game['rating']) : null,
                'platforms' => collect($game['platforms'])->pluck('abbreviation')->implode(', '),
            ]);
        })->toArray();
    }
}
