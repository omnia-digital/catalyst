<?php

namespace Modules\Games\Http\Livewire\Components;

use Livewire\Component;

class GameCardSmall extends Component
{
    public $game;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($game)
    {
        $this->game = $game;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('games::components.game-card-small');
    }
}
