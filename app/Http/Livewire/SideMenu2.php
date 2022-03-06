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
        $this->navigation = [
            [
                'label'   => 'Home',
                'name'    => 'social.home',
                'icon'    => 'heroicon-o-home',
                'current' => false
            ],
            [
                'label'   => 'Projects',
                'name'    => 'projects.home',
                'icon'    => 'heroicon-o-globe',
                'current' => false
            ],
            [
                'label'   => 'Resources',
                'name'    => 'resources.home',
                'icon'    => 'heroicon-o-newspaper',
                'current' => false
            ],
            [
                'label'   => 'Jobs',
                'name'    => 'jobs.home',
                'icon'    => 'heroicon-o-briefcase',
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
