<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MainNavLeft extends Component
{
    public $navigation;

    /**
     * Render the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('livewire.main-nav-left');
    }
}
