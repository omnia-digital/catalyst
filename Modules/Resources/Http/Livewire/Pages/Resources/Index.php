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
        'published_at' => '',
        'has_attachment' => false,
    ];

    public string $orderBy = 'published_at';

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

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        return $query;
    }

    public function getRowsQueryWithoutFiltersProperty()
    {
        return Post::where('type','=',PostType::RESOURCE)
            ->withCount('bookmarks')
            ->orderByDesc('published_at');
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
