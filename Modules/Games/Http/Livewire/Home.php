<?php

namespace Modules\Games\Http\Livewire;

use Livewire\Component;
use Modules\Games\Models\Game;

class Home extends Component
{
    public function getAllGamesProperty()
    {
        return Game::all();
    }

    public function render(): \Illuminate\View\View
    {
        return view('games::livewire.home', [
            'games' => $this->allGames,
        ]);
    }
}
