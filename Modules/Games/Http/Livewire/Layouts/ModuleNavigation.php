<?php

namespace Modules\Games\Http\Livewire\Layouts;

use Livewire\Component;

class ModuleNavigation extends Component
{
    public string $class;
    public array $navigation = [];

    public function mount()
    {
        $this->navigation = [
            [
                'label' => 'Home',
                'name' => 'games.home',
                'icon' => 'heroicon-o-home',
                'current' => false,
            ],
            //                [
            //                    'label'   => 'Reviews',
            //                    'name'    => 'games.reviews',
            //                    'icon'    => 'heroicon-o-globe',
            //                    'current' => false
            //                ],
            //                [
            //                    'label'   => 'Coming Soon',
            //                    'name'    => 'games.coming-soon',
            //                    'icon'    => 'heroicon-o-bell',
            //                    'current' => false
            //                ],
        ];
    }

    public function render()
    {
        return view('games::livewire.layouts.module-navigation');
    }
}
