<?php

namespace Modules\Social\Http\Livewire\Pages\Bookmarks;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Models\Bookmark;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Index extends Component
{
    use WithPagination, WithCachedRows;

    public ?string $search = null;

    public array $filters = [
        'created_at' => '',
        'has_attachment' => false,
    ];

    public array $sortLabels = [
        'created_at' => 'Date Created', 
    ];

    public string $orderBy = 'created_at';
    public bool $sortDesc = true;

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
        return Bookmark::where('user_id', '=', \Auth::user()->id);
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(24);
        });
    }

    public function render()
    {
        return view('social::livewire.pages.bookmarks.index', [
            'bookmarks' => $this->rows
        ]);
    }
}
