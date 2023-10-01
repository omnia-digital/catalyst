<?php

namespace Modules\Social\Http\Livewire\Components\Teams;

use App\Models\Location;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;

/**
 * @property array $places
 */
class TeamMap extends Component
{
    use WithMap;

    public ?string $startDate = null;

    protected $listeners = [
        'startDateUpdated' => 'handleStartDateUpdated',
    ];

    public function handleStartDateUpdated($data)
    {
        $this->startDate = $data['start_date'];

        $this->addPlaces('team-map', $this->places);
    }

    public function getPlacesProperty()
    {
        $places = Location::query()
            ->hasCoordinates()
            ->with('model')
            ->when($this->startDate, fn (Builder $query) => $query->whereHas('model',
                fn (Builder $query) => $query->whereDate('start_date', $this->startDate)))
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

    public function render()
    {
        return view('social::livewire.components.teams.team-map', [
            'places' => $this->places,
        ]);
    }
}
