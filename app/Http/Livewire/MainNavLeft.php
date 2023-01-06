<?php

namespace App\Http\Livewire;

use App\Settings\BillingSettings;
use Livewire\Component;

class MainNavLeft extends Component
{
    public $navigation;

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): \Illuminate\View\View
    {
        return view('livewire.main-nav-left');
    }
}
