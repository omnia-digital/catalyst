<?php

namespace Modules\Games\Http\Livewire\Components;

use Livewire\Component;
use Modules\Games\Actions\Games\GetPopularGamesAction;

class PopularGames extends Component
{
    public function getPopularGamesProperty(): \Illuminate\Support\Collection
    {
        return (new GetPopularGamesAction())->execute();
    }

    public function render(): \Illuminate\View\View
    {
        return view('games::livewire.components.popular-games', [
            'popularGames' => $this->popularGames,
        ]);
    }

}
