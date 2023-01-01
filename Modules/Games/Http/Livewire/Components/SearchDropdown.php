<?php

namespace Modules\Games\Http\Livewire\Components;

use Livewire\Component;
use Modules\Games\Actions\Games\GamesAction;

class SearchDropdown extends Component
{
    public $search = '';
    public $searchResults = [];

    public function render()
    {
        if (strlen($this->search) >= 2) {
            $this->searchResults = (new GamesAction())->search($this->search);
        }

        return view('games::livewire.components.search-dropdown');
    }
}
