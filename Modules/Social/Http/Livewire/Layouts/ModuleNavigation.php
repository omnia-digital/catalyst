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
                    'label'   => 'Explore',
                    'name'    => 'social.bookmarks',
                    'icon'    => 'heroicon-o-hashtag',
                    'current' => false
                ],
                [
                    'label'   => 'Notifications',
                    'name'    => 'social.bookmarks',
                    'icon'    => 'heroicon-o-bell',
                    'current' => false
                ],
                [
                    'label'   => 'Messages',
                    'name'    => 'social.bookmarks',
                    'icon'    => 'heroicon-o-chat',
                    'current' => false
                ],
                [
                    'label'   => 'Groups',
                    'name'    => 'social.bookmarks',
                    'icon'    => 'heroicon-o-user-group',
                    'current' => false
                ],
                [
                    'label'   => 'Contacts',
                    'name'    => 'social.contacts.show',
                    'icon'    => 'heroicon-o-users',
                    'current' => false
                ],
                [
                    'label'   => 'Bookmarks',
                    'name'    => 'social.bookmarks',
                    'icon'    => 'heroicon-o-bookmark',
                    'current' => false
                ],
            ];
        }

        public function render()
        {
            return view('social::livewire.layouts.module-navigation');
        }
    }
