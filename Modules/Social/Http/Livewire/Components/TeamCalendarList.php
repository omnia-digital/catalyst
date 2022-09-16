<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Location;
use App\Models\Team;
use App\Models\User;
use App\Traits\Filter\WithSortAndFilters;
use App\Traits\Team\WithTeamManagement;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class TeamCalendarList extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters, WithTeamManagement;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
        'start_date' => 'Launch Date'
    ];

    public string $dateColumn = 'start_date';

    public Team $team;

    public ?string $classes = '';

    protected $listeners = [
        'teamSelected' => 'handleTeamSelected'
    ];

    public function getRowsQueryProperty()
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
        return User::find(Auth::id());
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

    public function selectTeam($teamID)
    {
        $this->team = Team::find($teamID);
    }

    public function handleTeamSelected($teamId)
    {
        $this->selectTeam($teamId);

        $this->dispatchBrowserEvent('select-event', ['team' => $this->team]);
    }

    public function moreInfo()
    {
        return redirect()->route('social.teams.show', $this->team);
    }

    public function toggleMapCalendar($tab)
    {
        $this->emitUp('toggle_map_calendar', $tab, $this->places);
    }

    public function mount($classes = '')
    {
        $this->classes = $classes;
        $this->orderBy = 'name';

        if (!\App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function render()
    {
        return view('social::livewire.components.team-calendar-list', [
            'teams' => $this->rows,
            'teamsCount' => $this->rowsQuery->count()
        ]);
    }
}
