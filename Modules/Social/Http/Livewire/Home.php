<?php

namespace Modules\Social\Http\Livewire;

use App\Models\Location;
use Livewire\Component;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Home extends Component
{
    use WithMap, WithNotification, WithModal;

    public $tabs = [];

    public function mount()
    {
        $this->tabs = [
            [
                'name'    => 'Recent',
                'href'    => '#',
                'current' => true
            ],
            [
                'name'    => 'Most Liked',
                'href'    => '#',
                'current' => false,
            ],
            [
                'name'    => 'Most Answers',
                'href'    => '#',
                'current' => false
            ]
        ];
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
                    'users_count' => $location->model->users_count,
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
        return view('social::livewire.pages.home', [
            'places' => $this->places,
        ]);
    }
}
