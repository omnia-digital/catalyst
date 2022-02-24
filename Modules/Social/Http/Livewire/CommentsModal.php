<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;
use Modules\Social\Models\Post;

class CommentsModal extends Component
{
    public Post $post;

    public function mount(Post $post) {
        $this->post = $post;
    }

    public function render()
    {
        return view('social::livewire.comments-modal');
    }
}
