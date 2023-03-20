<?php

namespace Modules\Articles\Http\Livewire\Layouts;

use Livewire\Component;

class ModuleNavigation extends Component
{
    public string $class;
    public array $navigation = [];

    public function mount()
    {
        $this->navigation = [
            [
                'label'   => 'Discover',
                'name'    => 'articles.home',
                'icon'    => 'fa-regular fa-telescope',
                //                    'icon'    => 'fa-regular fa-earth-americas',
                //                    'icon'    => 'heroicon-o-globe',
                'module'  => 'articles',
                'current' => false
            ],
            [
                'label'   => \Trans::get('Media'),
                'name'    => 'articles.drafts',
                'icon'    => 'fa-regular fa-photo-film-music',
                //                    'icon'    => 'heroicon-o-briefcase',
                'module'  => 'articles',
                'current' => false
            ],
            [
                'label'   => \Trans::get('Articles'),
                'name'    => 'articles.drafts',
                'icon'    => 'fa-duotone fa-newspaper',
                //                    'icon'    => 'heroicon-o-briefcase',
                'module'  => 'articles',
                'current' => false
            ]
        ];
    }

    public function render()
    {
        return view('articles::livewire.layouts.module-navigation');
    }
}
