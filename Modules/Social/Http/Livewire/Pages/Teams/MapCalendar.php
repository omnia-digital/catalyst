<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use Livewire\Component;

class MapCalendar extends Component
{
    public $tab = 'calendar';

    public $places = null;

    protected $listeners = ['toggle_map_calendar' => 'toggleMapCalendar'];

    public function toggleMapCalendar($tab, $places)
    {
        $this->tab = $tab;
        $this->places = $places;
    }

    public function render()
    {
        return view('social::livewire.pages.teams.map-calendar');
    }
}
