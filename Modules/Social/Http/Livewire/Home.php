<?php

namespace Modules\Social\Http\Livewire;

use App\Models\Location;
use App\Support\Platform\Platform;
use App\Support\Platform\WithGuestAccess;
use Livewire\Component;
use Modules\Feeds\Models\FeedSource;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Home extends Component
{
    use WithMap, WithNotification, WithModal, WithGuestAccess;

    public $tabs = [];

    public function mount()
    {
        $this->tabs = [
            [
                'name' => 'Recent',
                'href' => '#',
                'current' => true,
            ],
            [
                'name' => 'Most Liked',
                'href' => '#',
                'current' => false,
            ],
            [
                'name' => 'Most Answers',
                'href' => '#',
                'current' => false,
            ],
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

    public function getNewsRssFeeds()
    {
        return Platform::isModuleEnabled('Feeds') ? FeedSource::first()->get() : collect();
    }

    public function render()
    {
        return view('social::livewire.pages.home', [
            'places' => $this->places,
            'newsRssFeeds' => $this->getNewsRssFeeds(),
        ]);
    }
}
