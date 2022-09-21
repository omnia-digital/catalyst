<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class DeletePostModal extends Component
{
    use WithModal, WithNotification;

    public Post $post;

    public ?string $content = null;

    public $confirmingDeletePost = false;

    protected $listeners = [
        'openDeletePostModal',
    ];

    public function openDeletePostModal(Post $post)
    {
        $this->post = $post;
        $this->confirmingDeletePost = true;
    }

    public function deletePost()
    {
        if ($this->post) {
            $this->post->delete();
            $this->success('Post deleted successfully');

            $this->emit('postDeleted');
        }

        $this->confirmingDeletePost = false;
    }

    public function render()
    {
        return view('social::livewire.partials.delete-post-modal');
    }
}
