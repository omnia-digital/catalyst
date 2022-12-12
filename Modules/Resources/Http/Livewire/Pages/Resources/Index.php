<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use App\Support\Platform\WithGuestAccess;
use App\Traits\Filter\WithSortAndFilters;
use Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;
use Platform;

use function view;

class Index extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters, WithGuestAccess;

    public array $sortLabels = [
        'title' => 'Title',
        'bookmarks_count' => 'Bookmarks',
        'likes_count' => 'Likes',
        'user_id' => 'User',
        'published_at' => 'Published Date'
    ];

    public string $dateColumn = 'published_at';

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

    public function loginCheck()
    {
        if (Platform::isAllowingGuestAccess() && !Auth::check()) {
            $this->showAuthenticationModal(route('resources.home'));

            return;
        }
    }

    public function getRowsQueryProperty()
    {
        $query = Post::where('type', '=', PostType::RESOURCE)
            ->withCount(['bookmarks', 'likes', 'media']);

        $query = $this->applyFilters($query);

        $query->where(function($q) {
            $q->where('title', 'like', "%{$this->search}%")
            ->orWhere('body', 'like', "%{$this->search}%");
        });

        $query = $this->applySorting($query);

        return $query;
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
