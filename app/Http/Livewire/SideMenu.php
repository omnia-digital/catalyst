<?php

    namespace App\Http\Livewire;

    use Livewire\Component;
    use App\Models\HeroIcons;

    class SideMenu extends Component
    {
        public $isOpen = false;

        public $navigation = [];

        public function mount() {
            $this->navigation = [
                [
                    'label'   => 'Community',
                    'name'    => 'social.home',
                    'icon'    => function ($classList) {
                        return HeroIcons::UsersIcon(...$classList);
                    },
                    'current' => false
                ],
                [
                    'label'   => 'Notifications',
                    'name'    => 'notifications',
                    'icon'    => function ($classList) {
                        return HeroIcons::BellIcon(...$classList);
                    },
                    'current' => false
                ],
                [
                    'label'   => 'Messages',
                    'name'    => 'messages',
                    'icon'    => function ($classList) {
                        return HeroIcons::MailIcon(...$classList);
                    },
                    'current' => false
                ],
                [
                    'label'   => 'Projects',
                    'name'    => 'projects',
                    'icon'    => function ($classList) {
                        return HeroIcons::CollectionIcon(...$classList);
                    },
                    'current' => false
                ],
                [
                    'label'   => 'Groups',
                    'name'    => 'groups',
                    'icon'    => function ($classList) {
                        return HeroIcons::InformationCircleIcon(...$classList);
                    },
                    'current' => false
                ],
                [
                    'label'   => 'Learn',
                    'name'    => 'learn',
                    'icon'    => function ($classList) {
                        return HeroIcons::AcademicCapIcon(...$classList);
                    },
                    'current' => false
                ],
                [
                    'label'   => 'Marketplace',
                    'name'    => 'marketplace',
                    'icon'    => function ($classList) {
                        return HeroIcons::OfficeBuildingIcon(...$classList);
                    },
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
            return view('livewire.side-menu');
        }
    }
