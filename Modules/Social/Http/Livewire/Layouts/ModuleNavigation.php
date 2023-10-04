<?php

namespace Modules\Social\Http\Livewire\Layouts;

use Livewire\Component;
use OmniaDigital\CatalystCore\Facades\Translate;

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
                'label' => Translate::get('Resources'),
                'name' => 'resources.home',
                'icon' => 'fa-regular fa-photo-film-music',
                'module' => 'resources',
            ],
            [
                'label' => Translate::get('Articles'),
                'name' => 'articles.home',
                'icon' => 'fa-duotone fa-newspaper',
                'module' => 'articles',
            ],
            [
                'label' => Translate::get('Teams'),
                'name' => 'social.teams.my-teams',
                'icon' => 'fa-solid fa-users',
                //                    'icon'    => 'heroicon-o-briefcase',
                'module' => 'social',
            ],
            [
                'label' => Translate::get('Map'),
                'name' => 'social.teams.map',
                'icon' => 'fa-regular fa-map',
                'module' => 'social',
            ],
            [
                'label' => Translate::get('Calendar'),
                'name' => 'social.teams.calendar',
                'icon' => 'fa-regular fa-calendar',
                'module' => 'social',
            ],
            //                [
            //                    'label'   => \Translate::get('Games'),
            //                    'name'    => 'games.home',
            //                    'icon'    => 'fa-regular fa-gamepad-modern',
            //                    'module'  => 'games',
            //                    'current' => false
            //                ],
            [
                'label' => Translate::get('News'),
                'name' => 'games.feeds',
                'icon' => 'fa-regular fa-rss',
                'module' => 'games',
            ],
            [
                'label' => Translate::get('Media Library'),
                'name' => 'media.index',
                'icon' => 'fa-regular fa-images',
            ],
            //                [
            //                    'label'   => 'Trending Posts',
            //                    'name'    => 'social.discover',
            //                    'icon'    => 'fa-solid fa-rectangle-history',
            //                ],
            //                [
            //                    'label'   => 'Bookmarks',
            //                    'name'    => 'social.bookmarks',
            //                    'icon'    => 'fa-regular fa-bookmark',
            ////                    'icon'    => 'heroicon-o-bookmark',
            //                    'module'  => 'social',
            //                ],
            //                [
            //                    'label'   => \Translate::get('Companies'),
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
