<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use Livewire\Component;

class Calendar extends Component
{
    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.pages.teams.calendar');
    }
}
