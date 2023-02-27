<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarItem extends Component
{
    public function __construct(
        public string $name,
        public string $to = '#',
        public ?string $icon = null,
        public bool $isSelected = false
    ) {}

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('partials.sidebar-item');
    }
}
