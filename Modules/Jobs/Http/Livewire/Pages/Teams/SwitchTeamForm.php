<?php

namespace Modules\Jobs\Http\Livewire\Pages\Teams;

use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class SwitchTeamForm extends Component
{
    public $company;

    public function mount()
    {
        $this->company = auth()->user()->currentTeam->id;
    }

    public function switchCompany()
    {
        $company = Jetstream::newTeamModel()->findOrFail($this->company);

        if (! auth()->user()->switchTeam($company)) {
            abort(403);
        }

        $this->redirectRoute('teams.show', auth()->user()->currentTeam->id);
    }

    public function render()
    {
        return view('teams.switch-team-form', [
            'companies' => auth()->user()->allTeams()->pluck('name', 'id')->all(),
        ]);
    }
}
