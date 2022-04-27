<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Livewire\Component;

/**
 * @property Builder $rowsQuery
 * @property Collection $rows
 */
class Teams extends Component
{
    public array $filters = [
        'location' => null,
        'date' => null,
        'members' => [0, 0],
        'rating' => [1]
    ];

    public function getRowsQueryProperty()
    {
        return Team::query()
            ->withCount('users')
            ->when(Arr::get($this->filters, 'location'), fn(Builder $query, $location) => $query->where('location', $location))
            ->when(Arr::get($this->filters, 'date'), fn(Builder $query, $date) => $query->whereDate('created_at', $date))
            ->when(Arr::get($this->filters, 'members'), fn(Builder $query, $members) => $query->havingBetween('users_count', $members))
            ->when(Arr::get($this->filters, 'rating'), fn(Builder $query, $rating) => $query->whereIn('rating', $rating));
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(25);
    }

    public function filter()
    {
        $this->callMethod('$refresh');
    }

    public function render()
    {
        return view('livewire.teams', [
            'projects' => $this->rows
        ]);
    }
}
