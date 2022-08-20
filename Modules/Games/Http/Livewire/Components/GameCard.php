<?php

namespace Modules\Games\Http\Livewire\Components;

use Livewire\Component;
use Modules\Games\Models\Game;

class GameCard extends Component
{
    protected ?Game $game = null;

    public function mount(Game $game): void
    {
        $this->game = $game;
    }

    public function showGame(): \Illuminate\Http\RedirectResponse
    {
        return redirect($this->game?->profile());
    }

    public function render(): \Illuminate\View\View
    {
        return view('games::livewire.components.game-card', [
            'game' => $this->game
        ]);
    }
}
