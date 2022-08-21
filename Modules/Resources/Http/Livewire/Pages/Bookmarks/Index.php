<?php

namespace Modules\Resources\Http\Livewire\Pages\Bookmarks;

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

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'search'}
     */
    protected $queryString = [
        'search'
    ];

    public function mount(): void
    {
        $this->orderBy = 'published_at';
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query;
    }

    /**
     * @psalm-return Builder<Bookmark&Builder<Bookmark&Builder<Bookmark&Builder<Bookmark>>>&Builder<Bookmark&Builder<Bookmark>>>|Builder<\Illuminate\Database\Eloquent\Model>
     */
    public function getRowsQueryWithoutFiltersProperty(): Builder
    {
        return Bookmark::where('user_id', '=', \Auth::user()->id)->whereHas('bookmarkable', function(Builder $query) {
            return $query->scopes(['ofType' => PostType::RESOURCE]);
        })
            ->orderBy($this->orderBy, $this->sortOrder);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(24);
        });
    }



    public function render(): \Illuminate\View\View
    {
        return view('resources::livewire.pages.bookmarks.index', [
            'bookmarks' => $this->rows
        ]);
    }
}
