<?php

namespace Modules\Games\Http\Livewire;

use Livewire\Component;
use Modules\Games\Models\Game;

class Show extends Component
{
    public string $slug;

    public function mount(string $slug)
    {
        $this->slug = $slug;
    }

    public function getGameProperty()
    {
        return Game::where('slug', $this->slug)->firstOrFail();
    }

    public function render()
    {
        return view('games::livewire.show',[
            'game' => $this->game,
        ]);
    }
}
