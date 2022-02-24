<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;
use Modules\Social\Models\Comment;

class CommentsModal extends Component
{
    public $recentlyAddedComment;
    public $commentsCount;
    public $body;
    public $post;
    protected $rules = [
        'body' => 'required|min:6',
    ];
    protected $listeners = ['commentAdded'];

    public function commentAdded(Comment $comment) {
        $this->recentlyAddedcomment = $comment;
        $this->commentsCount = $this->post->comments()->count();
    }

    

    public function mount($post) {
        $this->post = $post;
        $this->commentsCount = $post->comments()->count();
    }

    public function updated($propertyName) 
    {
        $this->validateOnly($propertyName);
    }

    public function saveComment()
    {
        $validatedData = $this->validate();

        $comment = $this->post->comment($validatedData, auth()->id());

        $this->reset(['body']);
        $this->emitSelf('commentAdded', $comment->id);
    }

    public function render()
    {
        return view('social::livewire.comments-modal');
    }
}
