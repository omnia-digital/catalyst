<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;
use function view;

class Index extends Component
{
    use WithPagination, WithCachedRows;

    public ?string $search = null;

    public array $filters = [
        'created_at' => '',
        'has_attachment' => false,
    ];

    public string $orderBy = 'title';
    public bool $sortDesc = true;

    protected $queryString = [
        'search'
    ];

    public function mount()
    {
        if (!\App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function sortBy($key)
    {
        if($this->orderBy === $key) {
            $this->sortDesc = !$this->sortDesc;
        } else {
            $this->orderBy = $key;
            $this->sertDesc = true;
        }
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query->where(function($q) {
            $q->where('title', 'like', "%{$this->search}%")
            ->orWhere('body', 'like', "%{$this->search}%");
        });
    }

    public function getRowsQueryWithoutFiltersProperty()
    {
        return Post::where('type','=',PostType::RESOURCE)
            ->withCount('bookmarks')
            ->withCount('likes')
            ->orderBy($this->orderBy, $this->sortDesc ? 'desc' : 'asc');
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(100);
        });
    }

    public function render()
    {
        return view('resources::livewire.pages.resources.index', [
            'resources' => $this->rows
        ]);
    }
}
