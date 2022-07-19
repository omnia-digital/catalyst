<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use App\Traits\Filter\WithSortAndFilters;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;
use function view;

class Index extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters;

    public ?string $search = null;

    public array $sortLabels = [
        'title' => 'Title',
        'bookmarks_count' => 'Bookmarks',
        'likes_count' => 'Likes',
        'user_id' => 'User',
        'published_at' => 'Published Date'
    ];

    protected $queryString = [
        'search'
    ];

    public function mount()
    {
        $this->orderBy = 'published_at';

        if (!\App::environment('production')) {
            $this->useCache = false;
        }
    }

    public function getRowsQueryProperty()
    {
        $query = clone $this->rowsQueryWithoutFilters;

        $query = $this->applyFilters($query);

        return $query
                ->where(function($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                    ->orWhere('body', 'like', "%{$this->search}%");
                })
                ->orderBy($this->orderBy, $this->sortOrder);
    }

    public function getRowsQueryWithoutFiltersProperty()
    {
        return Post::where('type', '=', PostType::RESOURCE)
            ->withCount(['bookmarks', 'likes', 'media']);
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
