<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class MainNavLeft extends Component
{
    public $navigation;

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.main-nav-left');
    }
}
