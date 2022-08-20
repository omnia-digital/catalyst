<?php

namespace Modules\Social\Http\Livewire\Pages\Bookmarks;

use App\Traits\Filter\WithSortAndFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Models\Bookmark;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Index extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters;

    public ?string $search = null;

    public array $sortLabels = [
        'created_at' => 'Date Created',
    ];

    public string $dateColumn = 'created_at';

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'search'}
     */
    protected array $queryString = [
        'search'
    ];

    public function mount(): void
    {
        $this->orderBy = "created_at";
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query;
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Builder<Bookmark>
     */
    public function getRowsQueryWithoutFiltersProperty(): \Illuminate\Database\Eloquent\Builder
    {
        return Bookmark::where('user_id', '=', \Auth::user()->id);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(24);
        });
    }

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.pages.bookmarks.index', [
            'bookmarks' => $this->rows
        ]);
    }
}
