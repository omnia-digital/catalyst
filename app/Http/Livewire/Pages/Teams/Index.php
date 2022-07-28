<?php

namespace App\Http\Livewire\Pages\Teams;

use App\Actions\Teams\GetTeamCategoriesAction;
use App\Lenses\Teams\NewReleaseTeamsLens;
use App\Lenses\WithLenses;
use App\Models\Team;
use App\Traits\Filter\WithSortAndFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\OmniaLibrary\Livewire\WithSorting;
use Spatie\Tags\Tag;

class Index extends Component
{
    use WithSortAndFilters, WithPagination, WithLenses;

    public array $sortLabels = [
        'name' => 'Name',
        'users_count' => 'Users',
        'start_date' => 'Launch Date'
    ];

    public string $dateColumn = 'start_date';

    public ?string $lens = null;

    protected $queryString = [
        'lens',
        'filters',
        'tags',
        'members',
        'dateFilter',
    ];

    public function mount()
    {
        $this->orderBy = 'name';
    }

    public function getRowsQueryProperty()
    {
        $query = Team::query()
            ->with('location')
            ->withCount('users');
            
        return $this->applyFilters($query)
            ->when($this->search, fn(Builder $q) => $q->search($this->search));
    }

    public function getRowsProperty()
    {
        $query = $this->applyLens($this->rowsQuery);
        $query = $this->applySorting($query);

        return $query->paginate(25);
    }

    public function getCategoriesProperty()
    {
        return (new GetTeamCategoriesAction)->execute();
    }

    public function render()
    {
        return view('livewire.pages.teams.index', [
            'teams' => $this->rows,
            'allTags' => $this->allTags,
            'categories' => $this->categories,
        ]);
    }
}
