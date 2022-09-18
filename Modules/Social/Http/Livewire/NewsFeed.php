<?php

namespace Modules\Social\Http\Livewire;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Models\Post;

class NewsFeed extends Component
{
    use WithPagination;

    public $perPage = 6;

    protected $listeners = [
        'postSaved',
        'postDeleted' => '$refresh'
    ];

    public Team|null $team = null;

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
            return $this->team->postsWithinTeam()->with(['user', 'user.profile', 'media'])->orderBy('published_at', 'desc');
        }
        return Post::with(['user', 'user.profile', 'media'])->orderBy('published_at', 'desc');
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->perPage);
    }

    public function render()
    {
        return view('social::livewire.partials.news-feed', [
            'feed' => $this->rows
        ]);
    }
}
