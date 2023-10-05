<?php

namespace App\Filament\Social\Pages;

use App\Models\Location;
use OmniaDigital\CatalystCore\Facades\Catalyst;
use OmniaDigital\CatalystCore\Support\Auth\WithGuestAccess;
use Filament\Pages\Page;
use Modules\Feeds\Models\FeedSource;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Home extends Page
{
    use WithGuestAccess, WithMap, WithModal, WithNotification;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.social.pages.home';

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

    public function getViewData(): array
    {
        return [
            'places' => $this->places,
            'newsRssFeeds' => $this->getNewsRssFeeds()
        ];
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return parent::render();

//        return view('social::livewire.pages.home', [
//            'places' => $this->places,
//            'newsRssFeeds' => $this->getNewsRssFeeds()
//        ]);
    }

    public function getNewsRssFeeds()
    {
        return Catalyst::isModuleEnabled('Feeds') ? FeedSource::first()->get() : collect();
    }
}
