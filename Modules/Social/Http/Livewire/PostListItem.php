<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;
use Modules\Social\Models\Post;

class PostListItem extends Component
{
    public Post $post;
    public $optionsMenuOpen = false;

    public function mount(Post $post) {
        $this->post = $post;
    }

    public function getAuthorAttribute() {
        return $this->post->user;
    }

    public function render()
    {
        return view('social::livewire.post-list-item');
    }
}
