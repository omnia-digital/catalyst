<?php

namespace Modules\Social\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\NewCommentNotification;
use Modules\Social\Support\Livewire\WithPostEditor;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class DeletePostDropdownItem extends Component
{
    public Post $post;
    public bool $show;

    public ?string $content = null;

    public function mount($post, $show = false)
    {
        $this->post = $post;
        $this->show = $show;
    }

    public function openDeleteModal()
    {
        $this->emitUp('delete-post-modal');
//        $this->emitTo('delete-post-modal','delete', $this->post);
    }

    public function render()
    {
        return view('social::livewire.partials.delete-post-dropdown-item');
    }
}