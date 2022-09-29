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

    public string|int|null $placeId = null;

    public $modelName = null;

    public $height= '500px';

    protected $listeners = [
        'select_event' => 'handleEventSelected',
    ];

    public function mount($modelName)
    {
        $this->modelName = $modelName;
    }

    public function handleEventSelected($eventId)
    {
        //$team = Team::find($eventId);
        $event = $this->modelName::find($eventId);

        if (!$event || !($location = $event->location()->first()) || !($location->lng) || !($location->lat)) {
            $this->error(\Trans::get('Cannot find the team or location. Please refresh the page and try again!'));

            return;
        }

        $this->flyTo('team-map', $location->lng, $location->lat);
    }

    public function showPlaceDetail($placeId)
    {
        $this->emitTo('social::components.team-calendar-list', 'teamSelected', $placeId);
    }

    public function getPlacesProperty()
    {
        $places = Location::query()
            ->hasCoordinates()
            ->with('model')
            ->get()
            ->map(function (Location $location) {
                return [
                    'id' => $location->model->id,
                    'name' => $location->model->name,
                    'description' => $this->getTeamDescriptionHTML($location),
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

    public function getTeamDescriptionHTML(Location $location)
    {
        $content = "";
        $content .= "<h3 class='h3 block'>{$location->model->name}</h2>";
        $content .= "<p>{$location->model->start_date->toFormattedDateString()}</p>";

        return $content;
    }

    public function render()
    {
        return view('social::livewire.pages.teams.map', [
            'places' => $this->places,
        ]);
    }
}
