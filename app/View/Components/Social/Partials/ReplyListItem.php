<?php

namespace App\View\Components\Social\Partials;

use Closure;
use Illuminate\View\Component;
use Modules\Social\Models\Post;

class ReplyListItem extends Component
{
    public Post $reply;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Post $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|Closure|string
     */
    public function render()
    {
        return view('components.social.partials.reply-list-item');
    }
}
