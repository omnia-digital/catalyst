<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;
use Modules\Social\Models\Post;

class NewsFeed extends Component
{
    protected $listeners = [
        'postSaved' => '$refresh'
    ];

    public function getRowsProperty()
    {
        return Post::with(['user', 'user.profile', 'media'])->latest()->get();
    }

    public function render()
    {
        return view('social::livewire.news-feed', [
            'feeds' => $this->rows
        ]);
    }
}
