<?php

namespace Modules\Social\Http\Livewire;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class NewsFeed extends Component
{
    use WithPagination;

    public $perPage = 6;

    public Team|null $team = null;

    protected $listeners = [
        'postSaved',
        'postDeleted' => '$refresh',
    ];

    public function postSaved()
    {
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 6;
    }

    public function hasMore()
    {
        return $this->perPage < $this->rowsQuery->count();
    }

    public function getRowsQueryProperty()
    {
        if ($this->team) {
            return $this->team->postsWithinTeam()->with(['user', 'user.profile', 'media', 'tags', 'bookmarks'])->orderBy('published_at', 'desc');
        }

        return Post::where('type', '!=', PostType::RESOURCE)->with(['user', 'user.profile', 'media', 'tags', 'bookmarks'])->orderByDesc('published_at')->orderByDesc('created_at');
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->perPage);
    }

    public function render()
    {
        return view('social::livewire.partials.news-feed', [
            'feed' => $this->rows,
        ]);
    }
}
