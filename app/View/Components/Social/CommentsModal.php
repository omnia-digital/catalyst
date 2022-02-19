<?php

namespace App\View\Components\Social;

use Illuminate\View\Component;
use Modules\Social\Models\Post;

class CommentsModal extends Component
{
    public Post $post;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.social.comments-modal');
    }
}
