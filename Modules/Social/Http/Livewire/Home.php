<?php

namespace Modules\Social\Http\Livewire;

use App\Models\Location;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;

class Home extends Component
{
    use WithMap;

    public $tabs = [];

    public $activities = [];

    public $questions = [];

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

        $this->activities = [];

        $this->questions = [];
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
        return view('social::livewire.pages.home', [
            'places' => $this->places,
        ]);
    }
}
