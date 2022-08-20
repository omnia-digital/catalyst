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

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'postSaved'}
     */
    protected array $listeners = ['postSaved'];

    public Team|null $team = null;

    public function postSaved(): void
    {
        $this->resetPage();
    }

    public function loadMore(): void
    {
        $this->perPage += 6;
    }

    public function hasMore(): bool
    {
        return $this->perPage < $this->rowsQuery->count();
    }

    /**
     * @psalm-return \Illuminate\Database\Eloquent\Builder<TRelatedModel>|\Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>
     */
    public function getRowsQueryProperty(): \Illuminate\Database\Eloquent\Builder
    {
        if ($this->team) {
            return $this->team->postsWithinTeam()->with(['user', 'user.profile', 'media'])->latest();
        }
        return Post::with(['user', 'user.profile', 'media'])->latest();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->perPage);
    }

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.partials.news-feed', [
            'feed' => $this->rows
        ]);
    }
}
