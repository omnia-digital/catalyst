<?php

namespace App\Traits\Filter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Spatie\Tags\Tag;

trait WithSortAndFilters
{
    public ?string $search = null;

    public string $orderBy = 'name';

    public string $sortOrder = 'desc';

    public string $defaultSortOrder = 'desc';

    public array $filters = [
        'has_attachment' => false,
        'location' => null,
        'rating' => [],
        'search' => null,
        'my_teams' => false,
    ];

    // Below properties should be nested in $filters,
    // but there is an error with Livewire cannot detect nested property.
    // When the error is fixed, put them back to $filters.
    // https://omniaapp.slack.com/archives/G01LA6L3H60/p1656660776169019
    public array $members = [0, 0];
    public array $tags = [];
    public ?string $dateFilter = null;

    public $filterCount = 0;

    public function sortBy($key)
    {
        $this->sortOrder = $this->defaultSortOrder;

        $this->orderBy = $key;
    }

    public function toggleSortOrder()
    {
        $this->sortOrder = ($this->sortOrder === 'asc') ? 'desc' : 'asc';
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedMembers()
    {
        $this->resetPage();
    }

    public function updatedTags()
    {
        $this->resetPage();
    }

    public function updatedDateFilter()
    {
        $this->resetPage();
    }

    public function updatedFilters()
    {
        $this->filterCount = count(array_filter($this->filters));
        $this->resetPage();
    }

    public function getAllTagsProperty()
    {
        return Tag::all()->mapWithKeys(fn(Tag $tag) => [$tag->name => $tag->name])->all();
    }

    public function applySorting(Builder $query): Builder
    {
        return $query->orderBy($this->orderBy, $this->sortOrder);
    }

    public function applyFilters(Builder $query): Builder
    {
        $table = $query->first()?->getTable();

        return $query
            ->when($this->filters['has_attachment'], fn(Builder $q) => $q->having('media_count', '>=', 1))
            // location filter
            ->when(Arr::get($this->filters, 'location'), fn(Builder $query, $location) => $query->whereHas('location',
                fn(Builder $query) => $query->search($location)))
            // date filter
            ->when($this->dateFilter,
                fn(Builder $query, $date) => $query->whereDate($table . '.' . $this->dateColumn, $date))
            // members filter
            ->when(max($this->members) > 0, fn(Builder $query) => $query->havingBetween('users_count', $this->members))
            // tags
            ->when(!empty($this->tags), fn(Builder $query) => $query->withAnyTags($this->tags))
            // my_teams
            ->when(Arr::get($this->filters, 'my_teams'), fn(Builder $query) => $query->withUser(auth()->user()));
        //->when(Arr::get($this->filters, 'rating'), fn(Builder $query, $rating) => $query->whereIn('rating', $rating))
    }
}
