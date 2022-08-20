<?php

namespace App\Http\Livewire;

use Livewire\Component;

/**
 * Side Menu should pull from Module's navigation
 */
class SideMenu extends Component
{
    public string $class;

    public $isOpen = false;

    public $navigation = [];

    public function mount(): void
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

    public function openMobileMenu(): void
    {
        $this->isOpen = true;
    }

    public function closeMobileMenu(): void
    {
        $this->isOpen = false;
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.side-menu-wide');
    }
}
