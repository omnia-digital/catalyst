<?php

namespace Modules\Social\Http\Livewire\Components\Teams;

use App\Models\Location;
use App\Models\Team;
use App\Models\User;
use App\Traits\Filter\WithSortAndFilters;
use App\Traits\Team\WithTeamManagement;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class TeamCalendarList extends Component
{
    use WithCachedRows, WithPagination, WithSortAndFilters, WithTeamManagement;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
        'start_date' => 'Launch Date',
    ];

    public string $dateColumn = 'start_date';

    public Team $team;

    public ?string $classes = '';

    public function mount($classes = ''): void
    {
        $this->classes = $classes;
        $this->orderBy = 'name';

        if (! App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function getRowsQueryProperty(): Builder
    {
        $query = Team::query()
            ->withCount(['users']);

        $query = $this->applyFilters($query);
        $query = $this->applySorting($query);

        return $query;
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(100);
        });
    }

    public function getUserProperty()
    {
        return User::find(auth()->id());
    }

    public function getPlacesProperty()
    {
        $places = Location::query()
            ->hasCoordinates()
            ->with('model')
            ->get()
            ->map(function (Location $location) {
                return [
                    'id' => $location->id,
                    'name' => $location->model->name,
                    'lat' => $location->lat,
                    'lng' => $location->lng,
                    'address' => $location->address,
                    'address_line_2' => $location->address_line_2,
                    'city' => $location->city,
                    'state' => $location->state,
                    'postal_code' => $location->postal_code,
                    'country' => $location->country,
                ];
            });

        return $places->all();
    }

    #[On('teamSelected')]
    public function handleTeamSelected($teamId): void
    {
        $this->selectTeam($teamId);

        $this->dispatch('select-event', team: $this->team);
    }

    public function selectTeam($teamID): void
    {
        $this->team = Team::find($teamID);
    }

    public function moreInfo(): RedirectResponse
    {
        return redirect()->route('social.teams.show', $this->team);
    }

    public function toggleMapCalendar($tab): void
    {
        $this->dispatch('toggle_map_calendar', tab: $tab, places: $this->places);
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('social::livewire.components.teams.team-calendar-list', [
            'teams' => $this->rows,
            'teamsCount' => $this->rowsQuery->count(),
        ]);
    }
}
