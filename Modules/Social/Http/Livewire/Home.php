<?php

namespace Modules\Social\Http\Livewire;

use App\Events\UserRegistered;
use App\Models\Location;
use App\Support\Platform\WithGuestAccess;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Home extends Component
{
    use WithMap, WithNotification, WithModal, WithGuestAccess;

    public $tabs = [];

    public function getListeners()
    {
        $userId = auth()->user()->id;

        return [
            "echo-private:notifications.{$userId},UserRegistered" => 'fireConfettiCannon',
        ];
    }

    public function fireConfettiCannon()
    {
        $this->emit('confetti');
    }

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
        $this->dispatchBrowserEvent('asdfs');

        $feeds = collect();
        $feeds->push(['', 'https://rss.app/feeds/YYS8qbgAE8mUDqIZ.xml']);
        $feeds->push(['', 'https://feeds.feedburner.com/ign/all']);
        $feeds->push(['', 'https://www.gamedeveloper.com/rss.xml']);
        $feeds->push(['', 'https://www.gamespot.com/feeds/game-news']);

        return $feeds;
    }

    public function render()
    {
        return view('social::livewire.pages.home', [
            'places' => $this->places,
            'newsRssFeeds' => $this->getNewsRssFeeds(),
        ]);
    }
}
