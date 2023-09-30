<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use App\Traits\Team\WithTeamManagement;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Modules\Forms\Models\Form;

class Apply extends Component
{
    use WithTeamManagement;

    public Team $team;

    public ?Form $applicationForm;

    public function mount(Team $team)
    {
        Gate::authorize('apply', $this->team);

        $this->team = $team;

        if (!$this->teamHasApplicationForm()) {
            $this->applyToTeam();

            $this->redirectRoute('social.teams.show', $this->team);
        }

        $this->applicationForm = $this->team->applicationForm();
    }

    public function render()
    {
        return view('social::livewire.pages.teams.apply');
    }
}
