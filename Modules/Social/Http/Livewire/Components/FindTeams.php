<?php

namespace Modules\Social\Http\Livewire\Components;

use Livewire\Component;

/**
 * @property array $places
 */
class FindTeams extends Component
{
    public ?string $startDate = null;

    public function updatedStartDate()
    {
        $component = $this->current === 'map'
            ? 'social::components.team-map'
            : 'social::components.current-week-team-calendar';

        $this->dispatch('startDateUpdated', start_date:$this->startDate)->to($component);

    }

    public function render()
    {
        return view('social::livewire.components.find-teams');
    }
}
