<?php

namespace Modules\Games\Http\Livewire;

use Livewire\Component;
use Modules\Games\Actions\Games\GamesAction;

class Home extends Component
{
    public $readyToLoad = false;

    public function load()
    {
        $this->readyToLoad = true;
    }

    public function getAllGamesProperty()
    {
        return (new GamesAction)->newlyReleased();
    }

    public function render()
    {
        return view('games::livewire.home', [
            'games' => $this->readyToLoad ? $this->allGames : collect(),
        ]);
    }
}
