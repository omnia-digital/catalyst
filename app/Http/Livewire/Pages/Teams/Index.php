<?php

namespace App\Http\Livewire\Pages\Teams;

use App\Actions\Teams\GetTeamCategoriesAction;
use App\Lenses\Teams\NewReleaseTeamsLens;
use App\Lenses\WithLenses;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\OmniaLibrary\Livewire\WithSorting;
use Spatie\Tags\Tag;

class Index extends Component
{
    use WithSorting, WithPagination, WithLenses;

    public ?string $lens = null;

    protected $queryString = [
        'lens',
        'filters',
        'tags',
        'members',
        'startDate'
    ];

    public array $filters = [
        'location' => null,
        'rating' => [],
        'search' => null,
    ];

    // Below properties should be nested in $filters,
    // but there is an error with Livewire cannot detect nested property.
    // When the error is fixed, put them back to $filters.
    // https://omniaapp.slack.com/archives/G01LA6L3H60/p1656660776169019
    public array $members = [0, 0];
    public array $tags = [];
    public ?string $startDate = null;

    public function updatedMembers()
    {
        $this->resetPage();
    }

    public function updatedTags()
    {
        $this->resetPage();
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->defaultSorting('name', 'asc');
    }

    public function getAllTagsProperty()
    {
        return Tag::all()->mapWithKeys(fn(Tag $tag) => [$tag->name => $tag->name])->all();
    }

    public function getRowsQueryProperty()
    {
        return Team::query()
            ->with('location')
            ->withCount('users as members')
            ->when(Arr::get($this->filters, 'location'), fn(Builder $query, $location) => $query->whereHas('location', fn(Builder $query) => $query->search($location)))
            ->when($this->startDate, fn(Builder $query, $date) => $query->whereDate('start_date', $date))
            ->when(max($this->members) > 0, fn(Builder $query) => $query->havingBetween('members', $this->members))
            ->when(!empty($this->tags), fn(Builder $query) => $query->withAnyTags($this->tags))
            //->when(Arr::get($this->filters, 'rating'), fn(Builder $query, $rating) => $query->whereIn('rating', $rating))
            ->when(Arr::get($this->filters, 'search'), fn(Builder $query, $search) => $query->search($search));
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
