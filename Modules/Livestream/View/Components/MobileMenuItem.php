<?php

namespace Modules\Livestream\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MobileMenuItem extends Component
{
    public function __construct(
        public string $name,
        public string $to = '#',
        public ?string $icon = null,
        public bool $isSelected = false
    ) {
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return View
     */
    public function render()
    {
        return view('partials.mobile-menu-item');
    }
}
