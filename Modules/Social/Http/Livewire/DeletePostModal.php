<?php

namespace Modules\Social\Http\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class DeletePostModal extends Component
{
    use WithModal, WithNotification, AuthorizesRequests;

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
        $this->authorize('delete', $this->post);

        if ($this->post) {
            $this->post->delete();
            $this->success('Post deleted successfully');

            $this->dispatch('postDeleted');
        }

        $this->confirmingDeletePost = false;
    }

    public function render()
    {
        return view('social::livewire.partials.delete-post-modal');
    }
}
