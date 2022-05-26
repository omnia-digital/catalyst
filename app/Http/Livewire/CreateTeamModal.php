<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;

class CreateTeamModal extends Component
{
    use WithModal;

    public ?string $name = null;

    public ?string $startDate = null;

    public ?string $summary = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:254'],
            'startDate' => ['required', 'date'],
            'summary' => ['required', 'max:280'],
        ];
    }

    public function create()
    {
        $this->validate();

        /** @var Team $team */
        $team = Auth::user()->ownedTeams()->create([
            'name' => $this->name,
            'start_date' => $this->startDate,
            'summary' => $this->summary,
            'personal_team' => false,
        ]);

        Auth::user()->switchTeam($team);

        $this->closeModal('create-team');
        $this->reset();

        $this->redirectRoute('teams.show', $team);
    }

    public function render()
    {
        return view('livewire.create-team-modal');
    }
}
