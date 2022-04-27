<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\OmniaLibrary\Livewire\WithSorting;

/**
 * @property Builder $rowsQuery
 * @property Collection $rows
 */
class Teams extends Component
{
    use WithSorting, WithPagination;

    public array $filters = [
        'location' => null,
        'date' => null,
        'members' => [0, 0],
        'rating' => [1],
        'search' => null
    ];

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->defaultSorting('name', 'asc');
    }

    public function getRowsQueryProperty()
    {
        return Team::query()
            ->withCount('users as members')
            ->when(Arr::get($this->filters, 'location'), fn(Builder $query, $location) => $query->where('location', $location))
            ->when(Arr::get($this->filters, 'date'), fn(Builder $query, $date) => $query->whereDate('created_at', $date))
            ->when(Arr::get($this->filters, 'members'), fn(Builder $query, $members) => $query->havingBetween('members', $members))
            ->when(Arr::get($this->filters, 'rating'), fn(Builder $query, $rating) => $query->whereIn('rating', $rating))
            ->when(Arr::get($this->filters, 'search'), fn(Builder $query, $search) => $query->search($search));
    }

    public function getRowsProperty()
    {
        $query = $this->applySorting($this->rowsQuery);

        return $query->paginate(25);
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
