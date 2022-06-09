<?php

namespace App\Http\Livewire\Pages\Teams;

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
        'filters'
    ];

    public array $filters = [
        'location' => null,
        'start_date' => null,
        'members' => [0, 0],
        'rating' => [],
        'search' => null,
        'tags' => []
    ];

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->defaultSorting('name', 'asc');
    }

    public function getTagsProperty()
    {
        return Tag::all()->mapWithKeys(fn(Tag $tag) => [$tag->name => $tag->name])->all();
    }

    public function getRowsQueryProperty()
    {
        return Team::query()
            ->with('location')
            ->withCount('users as members')
            ->when(Arr::get($this->filters, 'location'), fn(Builder $query, $location) => $query->whereHas('location', fn(Builder $query) => $query->search($location)))
            ->when(Arr::get($this->filters, 'start_date'), fn(Builder $query, $date) => $query->whereDate('start_date', $date))
            ->when(Arr::get($this->filters, 'members'), fn(Builder $query, $members) => $query->havingBetween('members', $members))
            ->when(Arr::get($this->filters, 'tags'), fn(Builder $query, $tags) => $query->withAnyTags($tags))
            //->when(Arr::get($this->filters, 'rating'), fn(Builder $query, $rating) => $query->whereIn('rating', $rating))
            ->when(Arr::get($this->filters, 'search'), fn(Builder $query, $search) => $query->search($search));
    }

    public function getRowsProperty()
    {
        $query = $this->applyLens($this->rowsQuery);
        $query = $this->applySorting($query);

        return $query->paginate(25);
    }

    public function render()
    {
        return view('livewire.pages.teams.index', [
            'teams' => $this->rows,
            'tags' => $this->tags
        ]);
    }
}
