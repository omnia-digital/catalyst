<?php

namespace Modules\Articles\Http\Livewire\Pages\Bookmarks;

use App\Traits\Filter\WithSortAndFilters;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Bookmark;
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
        'search'
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
        return Bookmark::where('user_id', '=', \Auth::user()->id)->whereHas('bookmarkable', function(Builder $query) {
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
        return view('articles::livewire.pages.bookmarks.index', [
            'bookmarks' => $this->rows
        ]);
    }
}
