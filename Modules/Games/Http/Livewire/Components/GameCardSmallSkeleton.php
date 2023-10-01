<?php

namespace Modules\Games\Http\Livewire\Components;

use Illuminate\View\View;
use Livewire\Component;

class GameCardSmallSkeleton extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('games::livewire.components.game-card-small-skeleton');
    }
}
