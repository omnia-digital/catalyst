<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Map extends Component
{
    use WithNotification;

    public function render()
    {
        return view('social::livewire.pages.teams.map');
    }
}
