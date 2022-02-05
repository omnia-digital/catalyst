<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;

class PostListItem extends Component
{
    public $post;
    public $optionsMenuOpen = false;

    public function mount($post) {
        $this->post = $post;
    }

    public function render()
    {
        return view('social::livewire.post-list-item');
    }
}
