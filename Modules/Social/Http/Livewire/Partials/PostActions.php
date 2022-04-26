<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;
use Modules\Social\Models\Post;

class PostActions extends Component
{
    public Post $post;

    public bool $show;

    public bool $showBookmarkButton = false;

    public function mount(Post $post, $show = false, $showBookmarkButton = false) {
        $this->post = $post;
        $this->show = $show;
        $this->showBookmarkButton = $showBookmarkButton;
    }

    public function render()
    {
        return view('social::livewire.partials.post-actions');
    }
}
