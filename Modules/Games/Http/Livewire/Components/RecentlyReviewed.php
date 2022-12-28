<?php

namespace Modules\Games\Http\Livewire\Components;

use Carbon\Carbon;
use Livewire\Component;
use MarcReichel\IGDBLaravel\Models\Cover;
use Modules\Games\Actions\Games\GamesAction;
use Modules\Games\Actions\Games\GetPopularGamesAction;
use Modules\Games\Models\Game;

class RecentlyReviewed extends Component
{
    public $readyToLoad = false;

    public function load()
    {
        $this->readyToLoad = true;
    }

    public function getRecentlyReviewedProperty()
    {
        return (new GamesAction())->recentlyReviewed();
    }

    public function render()
    {
        return view('games::livewire.components.recently-reviewed', [
            'recentlyReviewed' => $this->readyToLoad ? $this->recentlyReviewed : collect(),
        ]);
    }
}
