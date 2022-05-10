<?php

namespace Modules\Social\Http\Livewire;

use Illuminate\Pagination\Cursor;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Social\Models\Post;

class NewsFeed extends Component
{
    public $feed; // holds are list of posts.
    public $nextCursor; // holds our current page position.
    public $hasMorePages; // Tells us if we have more pages to paginate.

    protected $listeners = [
        'postSaved' => '$refresh',
        'load-more' => 'loadPosts',
    ];

    public function mount()
    {
        $this->feed = new Collection(); // initialize the data
        $this->loadPosts(); // load the data
    }


    public function loadPosts()
    {
        if ($this->hasMorePages !== null  && !$this->hasMorePages) {
            return;
        }

        $feed = Post::cursorPaginate(
            5,
            ['*'],
            'cursor',
            Cursor::fromEncoded($this->nextCursor)
        );
        $this->feed->push(...$feed->items());
        $this->hasMorePages = $feed->hasMorePages();
        if ($this->hasMorePages === true) {
            $this->nextCursor = $feed->nextCursor()->encode();
        }
    }

    public function render()
    {
        return view('social::livewire.news-feed');
    }
}
