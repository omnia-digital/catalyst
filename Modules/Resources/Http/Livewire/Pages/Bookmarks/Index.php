<?php

namespace Modules\Resources\Http\Livewire\Pages\Bookmarks;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Bookmark;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Index extends Component
{
    use WithPagination, WithCachedRows;

    public ?string $search = null;

    public array $filters = [
        'date_created' => '',
        'has_attachment' => false,
    ];

    public string $orderBy = 'date_created';

    protected $queryString = [
        'search'
    ];

    public function mount()
    {
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query;
    }

    public function getRowsQueryWithoutFiltersProperty()
    {
        return Bookmark::where('user_id', '=', \Auth::user()->id)->whereHas('bookmarkable', function(Builder $query) {
            return $query->scopes(['ofType' => PostType::RESOURCE]);
        });
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
            'bookmarks' => $this->rows
        ]);
    }
}
