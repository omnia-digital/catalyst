<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Location;
use App\Models\Team;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Map extends Component
{
    use WithMap, WithNotification;

    protected $listeners = [
        'select_event' => 'handleEventSelected'
    ];

    public function handleEventSelected($eventId)
    {
        $team = Team::find($eventId);

        if (!$team || !($location = $team->location()->first())) {
            $this->error('Cannot find the project or location. Please refresh the page and try again!');

            return;
        }

        $this->flyTo('project-map', $location->lng, $location->lat);
    }

    public function getPlacesProperty()
    {
        $places = Location::query()
            ->hasCoordinates()
            ->with('model')
            ->get()
            ->map(function (Location $location) {
                return [
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
        return view('social::livewire.pages.teams.map', [
            'places' => $this->places,
        ]);
    }
}
