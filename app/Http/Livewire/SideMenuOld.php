<?php

    namespace App\Http\Livewire;

    use Livewire\Component;

    class SideMenuOld extends Component
    {
        public $isOpen = false;

        public $navigation = [];

        public function mount() {
            $this->navigation = [
                [
                    'label'   => 'Community',
                    'name'    => 'social.home',
                    'icon'    => 'heroicon-o-users',
                    'current' => false
                ],
                [
                    'label'   => 'Notifications',
                    'name'    => 'notifications',
                    'icon'    => 'heroicon-o-bell',
                    'current' => false
                ],
                [
                    'label'   => 'Messages',
                    'name'    => 'messages',
                    'icon'    => 'heroicon-o-mail',
                    'current' => false
                ],
                [
                    'label'   => 'Projects',
                    'name'    => 'projects.home',
                    'icon'    => 'heroicon-o-collection',
                    'current' => false
                ],
                [
                    'label'   => 'Groups',
                    'name'    => 'groups',
                    'icon'    => 'heroicon-o-information-circle',
                    'current' => false
                ],
                [
                    'label'   => 'Learn',
                    'name'    => 'learn',
                    'icon'    => 'heroicon-o-academic-cap',
                    'current' => false
                ],
                [
                    'label'   => 'Marketplace',
                    'name'    => 'marketplace',
                    'icon'    => 'heroicon-o-office-building',
                    'current' => false
                ]
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
            return view('livewire.side-menu-old');
        }
    }
