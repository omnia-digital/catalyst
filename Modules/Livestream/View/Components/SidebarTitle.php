<?php

namespace Modules\Livestream\View\Components;

use Illuminate\View\Component;

class SidebarTitle extends Component
{
    public function __construct(
        public string $name,
        public ?string $icon = null,
    ) {}

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('partials.sidebar-title');
    }
}
