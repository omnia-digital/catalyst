<?php

namespace Modules\Games\Http\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Games\Actions\Games\GamesAction;

class ComingSoon extends Component
{
    public $readyToLoad = false;
    public $small = false;

    public function load()
    {
        $this->readyToLoad = true;
    }

    public function getComingSoonProperty()
    {
        return (new GamesAction)->comingSoon();
    }

    public function render()
    {
        return view('games::livewire.components.coming-soon', [
            'comingSoon' => $this->readyToLoad ? $this->comingSoon : collect(),
        ]);
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
