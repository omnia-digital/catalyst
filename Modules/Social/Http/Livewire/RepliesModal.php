<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;
use Modules\Social\Models\Post;

class RepliesModal extends Component
{
    public $recentlyAddedReply;
    public $replyCount;
    public $body;
    public $post;
    protected $rules = [
        'body' => 'required|min:6',
    ];
    protected $listeners = ['replyAdded'];

    public function replyAdded(Post $reply) {
        $this->recentlyAddedReply = $reply;
        $this->replyCount = $this->post->replies()->count();
    }

    

    public function mount($post) {
        $this->post = $post;
        $this->replyCount = $post->replies()->count();
    }

    public function updated($propertyName) 
    {
        $this->validateOnly($propertyName);
    }

    public function saveReply()
    {
        $validatedData = $this->validate();
       
        $reply = $this->post->reply($validatedData, auth()->id());

        $this->reset(['body']);
        $this->emitSelf('replyAdded', $reply->id);
    }

    public function render()
    {
        return view('social::livewire.replies-modal');
    }
}
