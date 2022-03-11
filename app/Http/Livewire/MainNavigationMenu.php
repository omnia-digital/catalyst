<?php

namespace App\Http\Livewire;

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
            [
                'label'   => 'Resources',
                'name'    => 'resources.home',
                'icon'    => 'heroicon-o-newspaper',
                'module'  => 'resources',
                'current' => false
            ],
            [
                'label'   => 'Jobs',
                'name'    => 'jobs.home',
                'icon'    => 'heroicon-o-briefcase',
                'module'  => 'jobs',
                'current' => false
            ],
            //                [
            //                    'label'   => 'Projects',
            //                    'name'    => 'projects.home',
            //                    'icon'    => 'heroicon-o-globe',
            //                    'current' => false
            //                ],
            //            [
            //                'label'   => 'CRM',
            //                'name'    => 'crm',
            //                'icon'    => 'heroicon-o-users',
            //                'current' => false
            //            ],
            //            [
            //                'label'   => 'Learn',
            //                'name'    => 'learn',
            //                'icon'    => 'heroicon-o-academic-cap',
            //                'current' => false
            //            ],
            //            [
            //                'label'   => 'Marketplace',
            //                'name'    => 'marketplace',
            //                'icon'    => 'heroicon-o-shopping-bag',
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
