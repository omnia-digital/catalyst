<?php

namespace Modules\Social\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\NewCommentNotification;
use Modules\Social\Support\Livewire\WithPostEditor;

class RepliesModal extends Component
{
    use WithPostEditor;

    public Post $post;

    public ?PostType $type = null;

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'postAdded', 'post-editor:submitted': 'saveComment'}
     */
    protected array $listeners = [
        'postAdded',
        'post-editor:submitted' => 'saveComment'
    ];
}
