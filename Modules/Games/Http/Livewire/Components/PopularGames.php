<?php

namespace Modules\Games\Http\Livewire\Components;

use Livewire\Component;
use Modules\Games\Actions\Games\GetPopularGamesAction;

class PopularGames extends Component
{
    public function getPopularGamesProperty()
    {
        return (new GetPopularGamesAction())->execute();
    }

    public function render()
    {
        return view('games::livewire.components.popular-games', [
            'popularGames' => $this->popularGames,
        ]);
    }

}
