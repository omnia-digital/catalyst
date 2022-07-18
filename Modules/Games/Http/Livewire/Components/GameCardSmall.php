<?php

namespace Modules\Games\Http\Livewire\Components;

use Livewire\Component;
use Modules\Games\Models\Game;

class GameCardSmall extends Component
{
    protected ?Game $game = null;

    public function mount($game_id = null)
    {
        if ($game_id) {
            $this->game = Game::find((int)$game_id);
        }
    }

    public function render()
    {
        return view('games::livewire.components.game-card-small', [
            'game' => $this->game
        ]);
    }
}
