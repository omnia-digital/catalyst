<?php

namespace Modules\Games\Http\Livewire;

use Livewire\Component;
use Modules\Games\Models\Game;

class Igdb extends Component
{
    public function getAllGamesProperty()
    {
        return Game::all();
    }

    public function render()
    {
        return view('games::livewire.igdb', [
            'games' => $this->allGames,
        ]);
    }
}
