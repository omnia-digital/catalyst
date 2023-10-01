<?php

namespace Modules\Social\Http\Livewire\Pages\Bookmarks;

use App\Support\Platform\Platform;
use App\Support\Platform\WithGuestAccess;
use App\Traits\Filter\WithSortAndFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Models\Bookmark;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Index extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters, WithGuestAccess;

    public ?string $search = null;

    public array $sortLabels = [
        'created_at' => 'Date Created',
    ];

    public string $dateColumn = 'created_at';

    protected $queryString = [
        'search',
    ];

    public function mount()
    {
        $this->orderBy = 'created_at';
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query;
    }

    public function getRowsQueryWithoutFiltersProperty()
    {
        return Bookmark::where('user_id', '=', auth()->user()?->id);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(24);
        });
    }

    public function showGuestAccessModal()
    {
        if (Platform::isAllowingGuestAccess() && !auth()->check()) {
            $this->showAuthenticationModal(route('social.bookmarks'));
        }
    }

    public function render()
    {
        return view('social::livewire.pages.bookmarks.index', [
            'bookmarks' => $this->rows,
        ]);
    }
}
