<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;
use Modules\Social\Models\Post;

class RepliesModal extends Component
{
    public $modalOpen = false;
    public $replyCount;
    public $post;
    public $show;
    protected $listeners = ['postAdded'];

    public function postAdded(Post $post) {
        $this->modalOpen = false;
        $this->replyCount = $this->post->comments()->count();
    }



    public function mount($post, $show = false) {
        $this->post = $post;
        $this->replyCount = $post->comments()->count();
        $this->show = $show;
    }

    public function render()
    {
        return view('social::livewire.replies-modal');
    }
}
