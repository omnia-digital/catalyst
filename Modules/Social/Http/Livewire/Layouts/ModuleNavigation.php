<?php

    namespace Modules\Social\Http\Livewire\Layouts;

    use Livewire\Component;

    class ModuleNavigation extends Component
    {
        public string $class;
        public array $navigation = [];

        public function mount() {
            $this->navigation = [
                [
                    'label'   => 'Home',
                    'name'    => 'social.home',
                    'icon'    => 'heroicon-o-home',
                    'current' => false
                ],
                [
                    'label'   => 'Discover',
                    'name'    => 'teams.discover',
                    'icon'    => 'heroicon-o-globe',
                    'current' => false
                ],
                [
                    'label'   => 'Notifications',
                    'name'    => 'notifications',
                    'icon'    => 'heroicon-o-bell',
                    'current' => false
                ],
                [
                    'label'   => \Trans::get('My Teams'),
                    'name'    => 'social.my-teams',
                    'icon'    => 'heroicon-o-briefcase',
                    'current' => false
                ],
                [
                    'label'   => 'Trending Posts',
                    'name'    => 'social.discover',
                    'icon'    => 'heroicon-o-collection',
                    'current' => false
                ],
                [
                    'label'   => 'Resources',
                    'name'    => 'resources.home',
                    'icon'    => 'heroicon-o-book-open',
                    'current' => false
                ],
                [
                    'label'   => 'Bookmarks',
                    'name'    => 'social.bookmarks',
                    'icon'    => 'heroicon-o-bookmark',
                    'current' => false
                ],
                [
                    'label'   => 'Contacts',
                    'name'    => 'social.contacts.index',
                    'icon'    => 'heroicon-o-users',
                    'current' => false
                ],
            ];
        }

        public function render()
        {
            return view('social::livewire.layouts.module-navigation');
        }
    }
