<?php

namespace Modules\Social\Http\Livewire\Layouts;

use Livewire\Component;
use Trans;

class ModuleNavigation extends Component
{
    public string $class;
    public array $navigation = [];

    public function mount()
    {
        $this->navigation = [
            [
                'label' => 'Home',
                'name' => 'social.home',
                'icon' => 'fa-regular fa-house',
                //                    'icon'    => 'fa-regular fa-house-chimney',
                //                    'icon'    => 'heroicon-o-home',
                'module' => 'social',
            ],
            [
                'label' => 'Discover',
                'name' => 'social.teams.discover',
                'icon' => 'fa-regular fa-telescope',
                //                    'icon'    => 'fa-regular fa-earth-americas',
                //                    'icon'    => 'heroicon-o-globe',
                'module' => 'social',
            ],
            [
                'label' => Trans::get('Resources'),
                'name' => 'resources.home',
                'icon' => 'fa-regular fa-photo-film-music',
                'module' => 'resources',
            ],
            [
                'label' => Trans::get('Articles'),
                'name' => 'articles.home',
                'icon' => 'fa-duotone fa-newspaper',
                'module' => 'articles',
            ],
            [
                'label' => Trans::get('My Teams'),
                'name' => 'social.teams.my-teams',
                'icon' => 'fa-regular fa-users',
                //                    'icon'    => 'heroicon-o-briefcase',
                'module' => 'social',
            ],
            [
                'label' => Trans::get('Map'),
                'name' => 'social.teams.map',
                'icon' => 'fa-regular fa-map',
                'module' => 'social',
            ],
            [
                'label' => Trans::get('Calendar'),
                'name' => 'social.teams.calendar',
                'icon' => 'fa-regular fa-calendar',
                'module' => 'social',
            ],
            //                [
            //                    'label'   => \Trans::get('Games'),
            //                    'name'    => 'games.home',
            //                    'icon'    => 'fa-regular fa-gamepad-modern',
            //                    'module'  => 'games',
            //                    'current' => false
            //                ],
            [
                'label' => Trans::get('News'),
                'name' => 'games.feeds',
                'icon' => 'fa-regular fa-rss',
                'module' => 'games',
            ],
            [
                'label' => Trans::get('Media Library'),
                'name' => 'media.index',
                'icon' => 'fa-regular fa-images',
            ],
            //                [
            //                    'label'   => 'Trending Posts',
            //                    'name'    => 'social.discover',
            //                    'icon'    => 'heroicon-o-collection',
            //                ],
            //                [
            //                    'label'   => 'Bookmarks',
            //                    'name'    => 'social.bookmarks',
            //                    'icon'    => 'fa-regular fa-bookmark',
            ////                    'icon'    => 'heroicon-o-bookmark',
            //                    'module'  => 'social',
            //                ],
            //                [
            //                    'label'   => \Trans::get('Companies'),
            //                    'name'    => 'social.companies.home',
            //                    'icon'    => 'fa-light fa-building',
            //                    //                    'icon'    => 'heroicon-o-bookmark',
            //                    'module'  => 'social',
            //                ],
            //                [
            //                    'label'   => 'Contacts',
            //                    'name'    => 'social.contacts.index',
            //                    'icon'    => 'heroicon-o-users',
            //                ],
        ];
    }

    public function render()
    {
        return view('social::livewire.layouts.module-navigation');
    }
}
