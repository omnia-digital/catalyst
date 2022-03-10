<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;
use Modules\Social\Models\Post;

class PostActions extends Component
{
    public $post;

    public $show;

    public function mount(Post $post, $show = false) {
        $this->post = $post;
        $this->show = $show;
    }

    public function render()
    {
        return view('social::livewire.partials.post-actions');
    }
}
