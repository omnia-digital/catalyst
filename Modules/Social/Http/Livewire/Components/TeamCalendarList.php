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
        'users_count' => 'Users'
    ];

    public $event;
    public $events = null;
    public $eventClassName;

    public ?string $classes = '';

    protected $listeners = [
        'teamSelected' => 'handleEventSelected'
    ];

    public function getRowsQueryProperty()
    {
        $query = $this->eventClassName::query()
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

    public function selectEventByID($eventID)
    {
        $this->event = $this->eventClassName::find($eventID);
    }

    public function handleEventSelected($eventID)
    {
        $this->selectEventByID($eventID);

        $this->dispatchBrowserEvent('select-event', ['team' => $this->event]);
    }

    public function moreInfo()
    {
        return redirect($this->event->detailsPage());
    }

    public function toggleMapCalendar($tab)
    {
        $this->emitUp('toggle_map_calendar', $tab, $this->places);
    }

    public function mount($events, $classes = '')
    {
        $this->eventClassName = get_class($events?->first());

        $dateColumn = $events?->first()->getDateColumn();
        $this->sortLabels[$dateColumn['column']] = $dateColumn['label'];

        $this->classes = $classes;
        //$this->orderBy = 'name';

        if (!\App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function render()
    {
        return view('social::livewire.components.team-calendar-list', [
            'eventList' => $this->rows,
            'teamsCount' => $this->rowsQuery->count()
        ]);
    }
}
