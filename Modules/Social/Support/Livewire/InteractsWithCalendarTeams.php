<?php

namespace Modules\Social\Support\Livewire;

use App\Models\Team;
use Illuminate\Support\Collection;

trait InteractsWithCalendarTeams
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     *
     * @psalm-return \Illuminate\Database\Eloquent\Collection<array-key, array{id: mixed, title: mixed, description: mixed, date: mixed, count: int, location: mixed}>|\Illuminate\Support\Collection<array-key, array{id: mixed, title: mixed, description: mixed, date: mixed, count: int, location: mixed}>
     */
    public function events(): Collection
    {
        return Team::query()
            ->whereDate('start_date', '>=', $this->gridStartsAt)
            ->whereDate('start_date', '<=', $this->gridEndsAt)
            ->get()
            ->map(function (Team $team) {
                return [
                    'id' => $team->id,
                    'title' => $team->name,
                    'description' => $team->summary,
                    'date' => $team->start_date,
                    'count' => $team->allUsers()->count(),
                    'location' => $team->location
                ];
            });
    }
}
