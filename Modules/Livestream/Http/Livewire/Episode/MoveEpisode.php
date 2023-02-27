<?php

namespace App\Http\Livewire\Episode;

use App\Models\Episode;
use App\Models\Team;
use App\Support\Livewire\WithNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * @property array $organizations
 */
class MoveEpisode extends Component
{
    use WithNotification, AuthorizesRequests;

    public bool $moveEpisodeModalOpen = false;

    public string|int $organization = '';

    public Episode $episode;

    public bool $loading = false;

    protected function rules(): array
    {
        return [
            'organization' => ['required']
        ];
    }

    public function getOrganizationsProperty()
    {
        return Auth::user()->allTeams()
            ->where('id', '!=', Auth::user()->currentTeam->id)
            ->pluck('name', 'id')
            ->all();
    }

    public function moveEpisode()
    {
        $this->loading = true;
        $this->authorize('view', $this->episode);

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

        $this->episode->update(['livestream_account_id' => $destinationLivestreamAccount->id]);
        $this->loading = false;
        $this->redirectRoute('episodes');
    }

    public function render()
    {
        return view('episode.move', [
            'organizations' => $this->organizations
        ]);
    }
}
