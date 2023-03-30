<?php

namespace App\Http\Livewire\Partials;

use Livewire\Component;

class SearchComponent extends Component
{
    public $placeholder = 'Search';

    public function render()
    {
        return view('livewire.partials.search-component');
    }
}
