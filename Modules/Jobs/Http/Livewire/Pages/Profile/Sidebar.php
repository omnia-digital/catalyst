<?php

namespace Modules\Jobs\Http\Livewire\Pages\Profile;

use Livewire\Component;

class Sidebar extends Component
{
    public $currentItem = 'Account';

    public function render()
    {
        $items = [
            [
                'name' => 'Account',
                'icon' => 'o-user-circle',
            ],
            [
                'name' => 'Security',
                'icon' => 'o-lock-closed',
            ],
            [
                'name' => 'Billing & Payments',
                'icon' => 'o-credit-card',
            ],
        ];

        return view('profile.sidebar', [
            'items' => $items,
        ]);
    }
}
