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
                    'icon'    => 'fa-regular fa-house',
//                    'icon'    => 'fa-regular fa-house-chimney',
//                    'icon'    => 'heroicon-o-home',
                    'module'  => 'social',
                    'current' => false
                ],
                [
                    'label'   => 'Discover',
                    'name'    => 'social.teams.discover',
                    'icon'    => 'fa-regular fa-telescope',
//                    'icon'    => 'fa-regular fa-earth-americas',
//                    'icon'    => 'heroicon-o-globe',
                    'module'  => 'social',
                    'current' => false
                ],
                [
                    'label'   => \Trans::get('Teams'),
                    'name'    => 'social.teams.home',
                    'icon'    => 'fa-regular fa-users',
//                    'icon'    => 'heroicon-o-briefcase',
                    'module'  => 'social',
                    'current' => false
                ],
                [
                    'label'   => \Trans::get('My Teams'),
                    'name'    => 'social.teams.my-teams',
                    'icon'    => 'fa-regular fa-users',
                    //                    'icon'    => 'heroicon-o-briefcase',
                    'module'  => 'social',
                    'current' => false
                ],
//                [
//                    'label'   => 'Notifications',
//                    'name'    => 'notifications',
//                    'icon'    => 'heroicon-o-bell',
//                    'current' => false
//                ],
//                [
//                    'label'   => \Trans::get('Menu'),
//                    'name'    => 'social.teams.my-teams',
//                    'icon'    => 'heroicon-o-briefcase',
//                    'current' => false
//                ],
                [
                    'label'   => \Trans::get('News'),
                    'name'    => 'games.feeds',
                    'icon'    => 'fa-regular fa-rss',
                    'module'  => 'games',
                    'current' => false
                ],
//                [
//                    'label'   => 'Trending Posts',
//                    'name'    => 'social.discover',
//                    'icon'    => 'heroicon-o-collection',
//                    'current' => false
//                ],
                [
                    'label'   => 'Resources',
                    'name'    => 'resources.home',
                    'icon'    => 'fa-regular fa-newspaper',
//                    'icon'    => 'fa-regular fa-newspaper',
//                    'icon'    => 'heroicon-o-book-open',
                    'module'  => 'social',
                    'current' => false
                ],
                [
                    'label'   => 'Bookmarks',
                    'name'    => 'social.bookmarks',
                    'icon'    => 'fa-regular fa-bookmark',
//                    'icon'    => 'heroicon-o-bookmark',
                    'module'  => 'social',
                    'current' => false
                ],
                [
                    'label'   => \Trans::get('Companies'),
                    'name'    => 'social.companies.home',
                    'icon'    => 'fa-light fa-building',
                    //                    'icon'    => 'heroicon-o-bookmark',
                    'module'  => 'social',
                    'current' => false
                ],
//                [
//                    'label'   => 'Contacts',
//                    'name'    => 'social.contacts.index',
//                    'icon'    => 'heroicon-o-users',
//                    'current' => false
//                ],
            ];
        }

        public function render()
        {
            return view('social::livewire.layouts.module-navigation');
        }
    }
