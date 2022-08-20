<?php

namespace Modules\Social\Http\Livewire;

use App\Models\Location;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;

class Home extends Component
{
    use WithMap;

    public $tabs = [];

    public function mount(): void
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

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.pages.home', [
            'places' => $this->places,
        ]);
    }
}
