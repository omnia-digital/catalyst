<?php

namespace App\Http\Livewire\Pages\Teams;

use App\Actions\Teams\GetCuratedTeamsAction;
use App\Actions\Teams\GetFeaturedTeamsAction;
use App\Actions\Teams\GetPopularIndiesTeamsAction;
use App\Actions\Teams\GetPopularUpcomingTeamsAction;
use App\Actions\Teams\GetTeamCategoriesAction;
use App\Actions\Teams\GetTrendingTeamsAction;
use App\Lenses\Teams\NewReleaseTeamsLens;
use App\Models\Location;
use Livewire\Component;

class Discover extends Component
{
    public function getPlacesProperty()
    {
        $places = Location::select(['lat', 'lng', 'model_id'])
            ->hasCoordinates()
            ->with('model')
            ->get()
            ->map(function (Location $teamLocation) {
                return [
                    'name' => $teamLocation->model->name,
                    'lat' => $teamLocation->lat,
                    'lng' => $teamLocation->lng,
                ];
            });

        return $places->all();
    }

    public function getCategoriesProperty()
    {
        return (new GetTeamCategoriesAction)->execute();
    }

    public function getCuratedTeamsProperty()
    {
        return (new GetCuratedTeamsAction)->execute();
    }

    public function getPopularIndiesTeamsProperty()
    {
        return (new GetPopularIndiesTeamsAction)->execute();
    }

    public function getPopularUpcomingTeamsProperty()
    {
        return (new GetPopularUpcomingTeamsAction)->execute();
    }

    public function getFeaturedTeamsProperty()
    {
        return (new GetFeaturedTeamsAction)->execute();
    }

    public function getTrendingTeamsProperty()
    {
        return (new GetTrendingTeamsAction)->execute();
    }

    public function render()
    {
        return view('livewire.pages.teams.discover', [
            'places' => $this->places,
            'featuredTeams' => $this->featuredTeams,
            'trendingTeams' => $this->trendingTeams,
            'categories' => $this->categories,
            'curatedTeams' => $this->curatedTeams,
            'popularIndiesTeams' => $this->popularIndiesTeams,
            'popularUpcomingTeams' => $this->popularUpcomingTeams,
        ]);
    }
}