<?php

namespace App\Http\Livewire\Pages\Teams;

use App\Actions\Teams\GetCuratedTeamsAction;
use App\Actions\Teams\GetFeaturedTeamsAction;
use App\Actions\Teams\GetPopularIndiesTeamsAction;
use App\Actions\Teams\GetPopularUpcomingTeamsAction;
use App\Actions\Teams\GetTeamCategoriesAction;
use App\Actions\Teams\GetTrendingTeamsAction;
use App\Lenses\Teams\NewReleaseTeamsLens;
use Livewire\Component;

class Discover extends Component
{
    public function getCategoriesProperty(): array
    {
        return (new GetTeamCategoriesAction)->execute();
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Collection<\Illuminate\Database\Eloquent\Model>
     */
    public function getCuratedTeamsProperty(): \Illuminate\Database\Eloquent\Collection
    {
        return (new GetCuratedTeamsAction)->execute();
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Collection<\Illuminate\Database\Eloquent\Model>
     */
    public function getPopularIndiesTeamsProperty(): \Illuminate\Database\Eloquent\Collection
    {
        return (new GetPopularIndiesTeamsAction)->execute();
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Collection<\Illuminate\Database\Eloquent\Model>
     */
    public function getPopularUpcomingTeamsProperty(): \Illuminate\Database\Eloquent\Collection
    {
        return (new GetPopularUpcomingTeamsAction)->execute();
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Collection<\Illuminate\Database\Eloquent\Model>
     */
    public function getFeaturedTeamsProperty(): \Illuminate\Database\Eloquent\Collection
    {
        return (new GetFeaturedTeamsAction)->execute();
    }

    /**
     * @return \Illuminate\Support\Collection|array
     */
    public function getTrendingTeamsProperty(): array|\Illuminate\Support\Collection
    {
        return (new GetTrendingTeamsAction)->execute();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.pages.teams.discover', [
            'featuredTeams' => $this->featuredTeams,
            'trendingTeams' => $this->trendingTeams,
            'categories' => $this->categories,
            'curatedTeams' => $this->curatedTeams,
            'popularIndiesTeams' => $this->popularIndiesTeams,
            'popularUpcomingTeams' => $this->popularUpcomingTeams,
        ]);
    }
}
