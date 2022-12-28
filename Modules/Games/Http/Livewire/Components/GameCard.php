<?php

namespace Modules\Games\Http\Livewire\Components;

use Livewire\Component;
use Modules\Games\Models\IGDB\Game;

class GameCard extends Component
{
    public $game;

    public function mount($game)
    {
        $this->game = $game;
    }

    public function showGame()
    {
        return redirect()->to($this->game->url);
    }

    public function render()
    {
        return view('games::livewire.components.game-card-steam', [
            'game' => $this->game
        ]);
    }
}
