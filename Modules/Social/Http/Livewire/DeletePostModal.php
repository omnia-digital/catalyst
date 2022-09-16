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

    protected $listeners = [
        'delete-post-modal:delete' => 'showDeletePostModal',
    ];

    public function showDeletePostModal()
    {
        $this->success('Post deleted successfully');
//        $this->post->delete();
//        $this->emitPostDeleted($data['id']);

        $this->openModal('delete-post-modal');
    }

    public function render()
    {
        return view('social::livewire.partials.delete-post-modal');
    }
}
