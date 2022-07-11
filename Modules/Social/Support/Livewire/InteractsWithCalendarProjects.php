<?php

namespace Modules\Social\Support\Livewire;

use App\Models\Team;
use Illuminate\Support\Collection;

trait InteractsWithCalendarProjects
{
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
