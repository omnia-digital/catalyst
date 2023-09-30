<?php

namespace Modules\Livestream\Http\Livewire\Person;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Livestream\Models\person;
use Modules\Livestream\Models\Team;
use Modules\Livestream\Support\Livewire\WithNotification;

/**
 * @property array $organizations
 */
class MovePerson extends Component
{
    use WithNotification, AuthorizesRequests;

    public bool $movepersonModalOpen = false;

    public string|int $organization = '';

    public person $person;

    public bool $loading = false;

    public function getOrganizationsProperty()
    {
        return auth()->user()->allTeams()
            ->where('id', '!=', auth()->user()->currentTeam->id)
            ->pluck('name', 'id')
            ->all();
    }

    public function moveperson()
    {
        $this->loading = true;
        $this->authorize('view', $this->person);

        $this->validate();

        if (!($destinationOrganization = Team::find($this->organization))) {
            $this->error('Cannot find the organization. Please refresh the page and try again!');
            $this->loading = false;

            return;
        }

        if (!($destinationLivestreamAccount = $destinationOrganization->livestreamAccount)) {
            $this->error('Cannot find the livestream account. Please refresh the page and try again!');
            $this->loading = false;

            return;
        }

        $this->person->update(['livestream_account_id' => $destinationLivestreamAccount->id]);
        $this->loading = false;
        $this->redirectRoute('people');
    }

    public function render()
    {
        return view('person.move', [
            'organizations' => $this->organizations,
        ]);
    }

    protected function rules(): array
    {
        return [
            'organization' => ['required'],
        ];
    }
}
