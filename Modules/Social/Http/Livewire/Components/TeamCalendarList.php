<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Location;
use App\Models\Team;
use App\Models\User;
use App\Traits\WithSortAndFilters;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class TeamCalendarList extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
        'start_date' => 'Launch Date'
    ];

    public $selectedID;

    public function getRowsQueryProperty()
    {
        $query = Team::query()
            ->withCount(['users', 'media']);

        $query = $this->applyFilters($query)
            ->orderBy($this->orderBy, $this->sortOrder);

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
        $places = Location::select(['lat', 'lng', 'model_id'])
            ->whereIn('model_id', $this->rows->pluck('id')->toArray())
            ->where('model_type', Team::class)
            ->hasCoordinates()
            ->with('model')
            ->get()
            ->map(function (Location $location) {
                return [
                    'name' => $location->model->name,
                    'lat' => $location->lat,
                    'lng' => $location->lng,
                ];
            });

        return $places->all();
    }

    public function selectEvent($eventID)
    {
        $this->selectedID = $eventID;
        $this->emit('select_event', $eventID);
    }

    public function toggleMapCalendar($tab)
    {
        $this->emitUp('toggle_map_calendar', $tab, $this->places);
    }

    public function mount()
    {
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
