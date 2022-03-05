<?php

namespace App\Http\Livewire;

use Livewire\Component;

/**
 * Side Menu should pull from Module's navigation
 */
class SideMenu2 extends Component
{
    public $isOpen = false;

    public $navigation = [];

    public function mount() {
    }

    public function openMobileMenu()
    {
        $this->isOpen = true;
    }

    public function closeMobileMenu()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.side-menu2');
    }
}
