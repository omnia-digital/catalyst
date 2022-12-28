<?php

namespace Modules\Games\Http\Livewire\Components;

use Livewire\Component;

class GameCardSkeleton extends Component
{

    public function __construct()
    {
    }
    public function render()
    {
        return view('games::livewire.components.game-card-skeleton');
    }
}
