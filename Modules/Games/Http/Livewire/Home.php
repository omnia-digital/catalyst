<?php

namespace Modules\Games\Http\Livewire;

use Livewire\Component;
use Modules\Games\Models\Game;

class Home extends Component
{
    public function getAllGamesProperty()
    {
        return Game::where('first_release_date', '>', now()->subDays(30))->orderBy('follows')->limit(4)->get();
    }

    public function render()
    {
        return view('games::livewire.home', [
            'games' => $this->allGames,
        ]);
    }
}
