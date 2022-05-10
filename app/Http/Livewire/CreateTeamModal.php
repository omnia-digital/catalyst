<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithPlace;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;

class CreateTeamModal extends Component
{
    use WithModal, WithPlace;

    public ?string $name = null;

    public ?string $location = null;

    public ?string $startDate = null;

    public ?string $summary = null;

    protected function placeApiKey(): ?string
    {
        return 'AIzaSyBpR-w9j3z1nyJas1Q2_XEagAcyssh7_gY';
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:254'],
            'location' => ['required', 'max:254'],
            'startDate' => ['required', 'date'],
            'summary' => ['required', 'max:280'],
        ];
    }

    public function create()
    {
        $this->validate();

        /** @var Team $team */
        $team = DB::transaction(function () {
            /** @var Team $team */
            $team = Auth::user()->ownedTeams()->create([
                'name' => $this->name,
                'location' => $this->location,
                'start_date' => $this->startDate,
                'summary' => $this->summary,
                'personal_team' => false,
            ]);

            $place = $this->findPlace();

            $team->teamLocations()->create([
                'address' => $place->address(),
                'address_line_2' => $place->add,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postalCode,
                'country' => $this->country,
            ]);

            Auth::user()->switchTeam($team);

            return $team;
        });

        $this->closeModal('create-team');
        $this->reset();

        $this->redirectRoute('teams.show', $team);
    }

    public function render()
    {
        return view('livewire.create-team-modal');
    }
}
