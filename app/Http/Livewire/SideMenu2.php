<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SideMenu2 extends Component
{
    public $isOpen = false;

    public $navigation = [];

    public function mount() {
        $this->navigation = [
            [
                'label'   => 'Home',
                'name'    => 'social.home',
                'icon'    => 'heroicon-o-home',
                'current' => false
            ],
            [
                'label'   => 'Projects',
                'name'    => 'social.projects',
                'icon'    => 'heroicon-o-globe',
                'current' => false
            ],
            [
                'label'   => 'CRM',
                'name'    => 'social.crm',
                'icon'    => 'heroicon-o-users',
                'current' => false
            ],
            [
                'label'   => 'Learn',
                'name'    => 'social.learn',
                'icon'    => 'heroicon-o-academic-cap',
                'current' => false
            ],
            [
                'label'   => 'Marketplace',
                'name'    => 'social.marketplace',
                'icon'    => 'heroicon-o-shopping-bag',
                'current' => false
            ],
        ];

        
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
