<?php

namespace Modules\Games\Http\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Games\Actions\Games\GamesAction;
use Modules\Games\Models\Game;

class MostAnticipated extends Component
{
    public $readyToLoad = false;

    public function load()
    {
        $this->readyToLoad = true;
    }
    public function getMostAnticipatedProperty()
    {
        return $this->formatForView((new GamesAction())->mostAnticipated());
    }

    public function render()
    {
        return view('games::livewire.components.most-anticipated', [
            'mostAnticipated' => $this->readyToLoad ? $this->mostAnticipated : collect(),
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
