<?php

namespace Modules\Social\Http\Livewire\Pages\Posts;

use Livewire\Component;
use Modules\Social\Models\Post;

class Show extends Component
{
    protected $listeners = ['postAdded' => '$refresh'];

    public $post;
    public $recentlyAddedComment;

    public function postAdded(Post $post) {
        $this->recentlyAddedComment = $post;
    }

    public function mount(Post $post)
    {
        $this->post = $post->load('comments');
    }

    public function render()
    {
        return view('social::livewire.pages.posts.show');
    }
}
