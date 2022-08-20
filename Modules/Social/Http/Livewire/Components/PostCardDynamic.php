<?php

namespace Modules\Social\Http\Livewire\Components;

use Livewire\Component;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use function view;

class PostCardDynamic extends PostCard
{
    public Post $post;
    public $clickable;

    /**
     * @return void
     */
    public function mount(Post $post, $clickable = true) {
        $this->post = $post;
        $this->clickable = $clickable;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('social::livewire.components.post-card-dynamic');
    }
}
