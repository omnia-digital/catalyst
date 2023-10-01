<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Trans;

class MainNavigationMenu extends Component
{
    public $navigation = [];

    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];

    public static function getDefaultNavItems()
    {
        return [
            [
                'label' => Trans::get('Home'),
                'name' => 'social.home',
                'icon' => 'fa-duotone fa-house',
                //                'icon'    => 'heroicon-o-home',
                'module' => 'social',
            ],
            [
                'label' => Trans::get('Teams'),
                'name' => 'social.home',
                'icon' => 'fa-solid fa-users',
                'module' => 'teams',
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
                'label' => Trans::get('News'),
                'name' => 'feeds.index',
                'icon' => 'fa-regular fa-rss',
                'module' => 'feeds',
            ],
            //            [
            //                'label'   => 'Games',
            //                'name'    => 'games.feeds',
            //                'icon'    => 'fa-regular fa-gamepad-modern',
            //                'module'  => 'games',
            //                'current' => false
            //            ],
            //            [
            //                'label' => Trans::get('Jobs'),
            //                'name' => 'jobs.home',
            //                'icon' => 'heroicon-o-briefcase',
            //                'module' => 'jobs',
            //            ],
            //            [
            //                'label' => 'Advice',
            //                'name' => 'advice.home',
            //                'icon' => 'fa-duotone fa-comments-question',
            //                'module' => 'advice',
            //            ],
            //            [
            //                'label' => Trans::get('CRM'),
            //                'name' => 'filament.pages.dashboard',
            //                'icon' => 'fa-duotone fa-rectangle-list',
            //                'module' => 'crm',
            //            ],
            //            [
            //                'label'   => 'Learn',
            //                'name'    => 'advice.home',
            //                'icon'    => 'heroicon-o-academic-cap',
            //                'module'  => 'advice',
            //                'current' => false
            //            ],
            //            [
            //                'label'   => 'Marketplace',
            //                'name'    => 'advice.home',
            //                'icon'    => 'heroicon-o-shopping-bag',
            //                'module'  => 'jobs',
            //                'current' => false
            //            ],

            [
                'label' => 'Livestream',
                'url' => 'https://app.omnia.church',
                'icon' => 'fa-duotone fa-camcorder',
                'module' => 'livestream',
            ],
        ];
    }

    public function mount()
    {
        $this->navigation = self::getDefaultNavItems();
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.main-navigation-menu');
    }
}
