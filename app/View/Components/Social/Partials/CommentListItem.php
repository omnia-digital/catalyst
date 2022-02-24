<?php

namespace App\View\Components\Social\Partials;

use Illuminate\View\Component;
use Modules\Social\Models\Comment;

class CommentListItem extends Component
{

    public Comment $comment;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.social.partials.comment-list-item');
    }
}
