<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MainNavigationMenu extends Component
{
    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];
}
