<?php

namespace App\Http\Livewire;

use Livewire\Component;

/**
 * Side Menu should pull from Module's navigation
 */
class SideMenu extends Component
{
    public $isOpen = false;

    public $navigation = [];

    public function mount()
    {
        if (empty($this->navigation)) {
            $this->navigation = [
                [
                    'label'   => 'No Module Navigation Items',
                    'name'    => 'social.home',
                    'icon'    => 'heroicon-o-x',
                    'current' => false
                ],
            ];
        }
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
        return view('livewire.side-menu');
    }
}
