<?php

namespace Modules\Jobs\Http\Livewire\Teams;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class SwitchTeamForm extends Component
{
    public $company;

    public function mount()
    {
        $this->company = Auth::user()->currentTeam->id;
    }

    public function switchCompany()
    {
        $company = Jetstream::newTeamModel()->findOrFail($this->company);

        if (!Auth::user()->switchTeam($company)) {
            abort(403);
        }

        $this->redirectRoute('teams.show', Auth::user()->currentTeam->id);
    }

    public function render()
    {
        return view('teams.switch-team-form', [
            'companies' => Auth::user()->allTeams()->pluck('name', 'id')->all()
        ]);
    }
}
