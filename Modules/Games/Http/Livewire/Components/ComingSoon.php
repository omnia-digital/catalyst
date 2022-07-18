<?php

namespace Modules\Games\Http\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Games\Models\Game;

class ComingSoon extends Component
{
    public $comingSoon = [];

    public function loadComingSoon()
    {
        $current = Carbon::now()->timestamp;

        $comingSoonUnformatted = Game::where('first_release_date', '>', $current)
            ->where('first_release_date', '<', $current + (60 * 60 * 24 * 7))
            ->get();

//        $comingSoonUnformatted = Http::withHeaders(config('services.igdb'))
//            ->withOptions([
//                'body' => "
//                    fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count, summary, slug;
//                    where platforms = (48,49,130,6)
//                    & (first_release_date >= {$current}
//                    & popularity > 5);
//                    sort first_release_date asc;
//                    limit 4;
//                "
//            ])->get('https://api-v3.igdb.com/games')
//            ->json();

        $this->comingSoon = $comingSoonUnformatted;
//        $this->comingSoon = $this->formatForView($comingSoonUnformatted);
    }

    public function render()
    {
        return view('games::livewire.components.coming-soon');
    }

    private function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => $game->cover_url,
                'releaseDate' => Carbon::parse($game['first_release_date'])->format('M d, Y'),
            ]);
        })->toArray();
    }
}
