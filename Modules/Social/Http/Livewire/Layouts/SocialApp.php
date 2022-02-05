<?php

namespace Modules\Social\Http\Livewire\Layouts;

use Livewire\Component;

class SocialApp extends Component
{
    public $navigation = [];

    public function mount()
    {
        $this->navigation = [

        ];
    }

    public function render()
    {
        return view('social::livewire.layouts.social-app');
    }
}
