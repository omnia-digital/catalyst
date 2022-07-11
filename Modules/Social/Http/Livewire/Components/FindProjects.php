<?php

namespace Modules\Social\Http\Livewire\Components;

use Livewire\Component;

/**
 * @property array $places
 */
class FindProjects extends Component
{
    public ?string $startDate = null;

    public string $current = 'map';

    public function updatedStartDate()
    {
        $component = $this->current === 'map'
            ? 'social::components.team-map'
            : 'social::components.current-week-team-calendar';

        $this->emitTo($component, 'startDateUpdated', [
            'start_date' => $this->startDate
        ]);
    }

    public function render()
    {
        return view('social::livewire.components.find-projects');
    }
}
