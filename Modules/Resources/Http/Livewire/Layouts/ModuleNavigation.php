<?php

namespace Modules\Resources\Http\Livewire\Layouts;

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
                'label' => 'Discover',
                'name' => 'resources.home',
                'icon' => 'fa-regular fa-telescope',
                //                    'icon'    => 'fa-regular fa-earth-americas',
                //                    'icon'    => 'heroicon-o-globe',
                'module' => 'resources',
                'current' => false,
            ],
            [
                'label' => Translate::get('Media'),
                'name' => 'resources.drafts',
                'icon' => 'fa-regular fa-photo-film-music',
                //                    'icon'    => 'heroicon-o-briefcase',
                'module' => 'resources',
                'current' => false,
            ],
            [
                'label' => Translate::get('Articles'),
                'name' => 'resources.drafts',
                'icon' => 'fa-duotone fa-newspaper',
                //                    'icon'    => 'heroicon-o-briefcase',
                'module' => 'resources',
                'current' => false,
            ],
        ];
    }

    public function render()
    {
        return view('resources::livewire.layouts.module-navigation');
    }
}
