<?php

namespace App\Http\Livewire;

use Livewire\Component;

/**
 * Side Menu should pull from Module's navigation
 */
class SideMenu extends Component
{


    /**
     * @var (false|string)[][]
     *
     * @psalm-var array{0?: array{label: 'No Module Navigation Items', name: 'social.home', icon: 'heroicon-o-x', current: false}}
     */
    public array $navigation = [];
}
