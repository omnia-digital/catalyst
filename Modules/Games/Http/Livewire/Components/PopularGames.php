<?php

namespace Modules\Games\Http\Livewire\Components;

use Livewire\Component;
use Modules\Games\Actions\Games\GamesAction;

class PopularGames extends Component
{
    public $readyToLoad = false;

    public function load()
    {
        $this->readyToLoad = true;
    }

    public function getPopularGamesProperty()
    {
        return (new GamesAction)->popular();
    }

    public function render()
    {
        return view('games::livewire.components.popular-games', [
            'popularGames' => $this->readyToLoad ? $this->popularGames : collect(),
        ]);
    }
}
