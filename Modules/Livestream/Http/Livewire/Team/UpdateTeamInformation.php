<?php

namespace Modules\Livestream\Http\Livewire\Team;

use Modules\Livestream\Models\Team;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Contracts\UpdatesTeamNames;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateTeamInformation extends Component
{
    use WithFileUploads;

    public Team $team;

    public array $state = [];

    public $logo;

    /**
     * Mount the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->state = $this->team->withoutRelations()->toArray();
        $this->logo = $this->team->logo;

        // Since we want to force user to enter their org name (team name)
        // so if they have default team name, let set it empty.
        if ($this->team->hasDefaultTeamName()) {
            $this->state['name'] = null;
        }
    }

    /**
     * Update the team's information.
     *
     * @param \Laravel\Jetstream\Contracts\UpdatesTeamNames $updater
     * @return void
     */
    public function updateTeamName(UpdatesTeamNames $updater)
    {
        $this->resetErrorBag();

        $updater->update($this->user, $this->team, !is_string($this->logo)
            ? array_merge($this->state, ['logo' => $this->logo])
            : $this->state);

        if (isset($this->photo)) {
            return redirect()->route('teams.show', $this->team);
        }

        $this->emit('saved');
        $this->emit('refresh-navigation-menu');
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Delete user's profile photo.
     *
     * @return void
     */
    public function deleteLogo()
    {
        $this->team->deleteLogo();

        return redirect()->route('teams.show', $this->team);
    }

    public function render()
    {
        return view('team.update-team-information');
    }
}
