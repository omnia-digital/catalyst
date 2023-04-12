<?php

namespace Modules\Advice\Http\Livewire\Layouts;

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
                'name' => 'advice.home',
                'icon' => 'fa-regular fa-house',
                'module' => 'social',
            ],
        ];
    }

    public function render()
    {
        return view('advice::livewire.layouts.module-navigation');
    }
}
