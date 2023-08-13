<?php

namespace App\Livewire;

use Livewire\Component;

/**
 * Side Menu should pull from Module's navigation
 */
class SideMenu extends Component
{
    public string $class;

    public $isOpen = false;

    public $navigation = [];

    public function mount()
    {
        if (empty($this->navigation)) {
            $this->navigation = [
                [
                    'label' => 'No Module Navigation Items',
                    'name' => 'social.home',
                    'icon' => 'x-mark',
                    'current' => false,
                ],
            ];
        }
    }

    public function render()
    {
        return view('livewire.side-menu-wide');
    }
}
