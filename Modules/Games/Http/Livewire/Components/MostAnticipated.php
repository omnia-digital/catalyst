<?php

namespace Modules\Games\Http\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Games\Models\Game;

class MostAnticipated extends Component
{
    public $mostAnticipated = [];

    public function loadMostAnticipated()
    {
        $current = Carbon::now()->timestamp;
        $afterFourMonths = Carbon::now()->addMonths(4)->timestamp;

        $mostAnticipatedUnformatted = Game::where('first_release_date', '>', $current)
            ->where('first_release_date', '<', $afterFourMonths)
            ->get();

//        $mostAnticipatedUnformatted = Http::withHeaders(config('services.igdb'))
//            ->withOptions([
//                'body' => "
//                    fields name, cover.url, first_release_date, popularity, platforms.abbreviation, rating, rating_count, summary, slug;
//                    where platforms = (48,49,130,6)
//                    & (first_release_date >= {$current}
//                    & first_release_date < {$afterFourMonths});
//                    sort popularity desc;
//                    limit 4;
//                "
//            ])->get('https://api-v3.igdb.com/games')
//            ->json();

//        $this->mostAnticipated = $this->formatForView($mostAnticipatedUnformatted);
        $this->mostAnticipated = $mostAnticipatedUnformatted;
    }

    public function render()
    {
        return view('games::livewire.components.most-anticipated');
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
