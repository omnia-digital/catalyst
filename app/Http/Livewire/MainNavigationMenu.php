<?php

namespace App\Http\Livewire;

use App\Settings\BillingSettings;
use Livewire\Component;

class MainNavigationMenu extends Component
{
    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [
        'refresh-navigation-menu' => '$refresh',
    ];

    public function getIsUsingUserSubscriptionsProperty()
    {
        return (new BillingSettings())->user_subscriptions;
    }

    public function mount()
    {
        $this->navigation = [
            [
                'label'   => 'Community',
                'name'    => 'social.home',
                'icon'    => 'heroicon-o-globe',
                'module'  => 'social',
                'current' => false
            ],
//            [
//                'label'   => 'Resources',
//                'name'    => 'resources.home',
//                'icon'    => 'heroicon-o-newspaper',
//                'module'  => 'resources',
//                'current' => false
//            ],
            [
                'label'   => 'Games',
                'name'    => 'games.home',
                'icon'    => 'heroicon-o-newspaper',
                'module'  => 'games',
                'current' => false
            ],
//            [
//                'label'   => 'Jobs',
//                'name'    => 'jobs.home',
//                'icon'    => 'heroicon-o-briefcase',
//                'module'  => 'jobs',
//                'current' => false
//            ],
//            [
//                'label'   => 'Advice',
//                'name'    => 'advice.home',
//                'icon'    => 'heroicon-o-briefcase',
//                'module'  => 'advice',
//                'current' => false
//            ],
//            [
//                'label'   => 'Crm',
//                'name'    => 'social.crm',
//                'icon'    => 'heroicon-o-users',
//                'module'  => 'advice',
//                'current' => false
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
        ];


    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): \Illuminate\View\View
    {
        return view('livewire.main-navigation-menu');
    }
}
