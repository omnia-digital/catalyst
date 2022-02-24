<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;

class CommentsModal extends Component
{
    public $comments;
    public $commentsCount;

    public function mount($comments, $commentsCount) {
        $this->comments = $comments;
        $this->commentsCount = $commentsCount;
    }

    public function render()
    {
        return view('social::livewire.comments-modal');
    }
}
