<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;
use function view;

class Index extends Component
{
    use WithPagination, WithCachedRows;

    public ?string $search = null;

    public array $filters = [
        'date_created' => '',
        //        'has_attachment' => false,
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
        return Post::where('type','=','resource');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(24);
        });
    }

    public function render()
    {
        return view('resources::livewire.pages.resources.index', [
            'resources' => $this->rows
        ]);
    }
}