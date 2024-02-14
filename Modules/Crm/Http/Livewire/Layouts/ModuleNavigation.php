<?php

namespace Modules\Crm\Http\Livewire\Layouts;

use Livewire\Component;

class ModuleNavigation extends Component
{
    public string $class;
    public array $navigation = [];

    public function mount()
    {
        $this->navigation = [
            [
                'label' => 'People',
                'name' => 'crm.people',
                'icon' => 'fa-regular fa-users',
                //                    'icon'    => 'fa-regular fa-house-chimney',
                //                    'icon'    => 'heroicon-o-home',
                'module' => 'crm',
                'current' => false,
            ],
            [
                'label' => 'Campaigns',
                'name' => 'crm.reviews',
                'icon' => 'fa-regular fa-house',
                //                    'icon'    => 'fa-regular fa-house-chimney',
                //                    'icon'    => 'heroicon-o-home',
                'module' => 'crm',
                'current' => false,
            ],
            [
                'label' => 'Transactions',
                'name' => 'crm.reviews',
                'icon' => 'fa-regular fa-house',
                //                    'icon'    => 'fa-regular fa-house-chimney',
                //                    'icon'    => 'heroicon-o-home',
                'module' => 'crm',
                'current' => false,
            ],
            [
                'label' => 'Recurring Payments',
                'name' => 'crm.reviews',
                'icon' => 'fa-regular fa-house',
                //                    'icon'    => 'fa-regular fa-house-chimney',
                //                    'icon'    => 'heroicon-o-home',
                'module' => 'crm',
                'current' => false,
            ],
            [
                'label' => 'Tickets',
                'name' => 'crm.reviews',
                'icon' => 'fa-regular fa-house',
                //                    'icon'    => 'fa-regular fa-house-chimney',
                //                    'icon'    => 'heroicon-o-home',
                'module' => 'crm',
                'current' => false,
            ],
            [
                'label' => 'Payouts',
                'name' => 'crm.reviews',
                'icon' => 'fa-regular fa-house',
                //                    'icon'    => 'fa-regular fa-house-chimney',
                //                    'icon'    => 'heroicon-o-home',
                'module' => 'crm',
                'current' => false,
            ],
            [
                'label' => 'Reviews',
                'name' => 'crm.reviews',
                'icon' => 'fa-regular fa-house',
                //                    'icon'    => 'fa-regular fa-house-chimney',
                //                    'icon'    => 'heroicon-o-home',
                'module' => 'crm',
                'current' => false,
            ],
            [
                'label' => 'Integrations',
                'name' => 'crm.reviews',
                'icon' => 'fa-regular fa-house',
                //                    'icon'    => 'fa-regular fa-house-chimney',
                //                    'icon'    => 'heroicon-o-home',
                'module' => 'crm',
                'current' => false,
            ],
        ];
    }

    public function render()
    {
        return view('catalyst::livewire.layouts.module-navigation');
    }
}
