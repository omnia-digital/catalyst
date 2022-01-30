<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\HeroIcons;

class SideMenu extends Component
{
    public $isOpen = false;

    public function openMobileMenu() {
        $this->isOpen = true;
    }

    public function closeMobileMenu() {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.side-menu');
    }
}
