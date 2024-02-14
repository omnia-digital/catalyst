<?php

namespace Modules\Resources\Http\Livewire\Pages\Bookmarks;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use OmniaDigital\CatalystCore\Enums\PostType;
use OmniaDigital\CatalystCore\Models\Bookmark;
use OmniaDigital\CatalystCore\Traits\Filter\WithSortAndFilters;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Index extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters;

    public ?string $search = null;

    public array $sortLabels = [
        'published_at' => 'Date Created',
    ];

    public string $dateColumn = 'published_at';

    protected $queryString = [
        'search',
    ];

    public function mount()
    {
        $this->orderBy = 'published_at';
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query;
    }

    public function getRowsQueryWithoutFiltersProperty()
    {
        return Bookmark::where('user_id', '=', auth()->user()->id)->whereHas('bookmarkable', function (Builder $query) {
            return $query->scopes(['ofType' => PostType::ARTICLE]);
        })
            ->orderBy($this->orderBy, $this->sortOrder);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(24);
        });
    }

    public function render()
    {
        return view('resources::livewire.pages.bookmarks.index', [
            'bookmarks' => $this->rows,
        ]);
    }
}
