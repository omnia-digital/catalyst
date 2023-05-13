<?php

namespace Modules\Games\Http\Livewire\Components;

use Livewire\Component;
use Modules\Games\Actions\Games\GamesAction;

class RecentlyReviewed extends Component
{
    public $readyToLoad = false;

    public function load()
    {
        $this->readyToLoad = true;
    }

    public function getRecentlyReviewedProperty()
    {
        return (new GamesAction)->recentlyReviewed();
    }

    public function render()
    {
        return view('games::livewire.components.recently-reviewed', [
            'recentlyReviewed' => $this->readyToLoad ? $this->recentlyReviewed : collect(),
        ]);
    }
}
