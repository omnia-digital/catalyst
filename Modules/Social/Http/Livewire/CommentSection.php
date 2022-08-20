<?php

namespace Modules\Social\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\NewCommentNotification;
use Modules\Social\Support\Livewire\WithPostEditor;

class CommentSection extends Component
{
    use WithPostEditor;

    public Post $post;

    public ?PostType $type = null;

    /**
     * @var string[]
     *
     * @psalm-var array{'post-editor:submitted': 'saveComment'}
     */
    protected array $listeners = [
        'post-editor:submitted' => 'saveComment'
    ];

    private function loadComments(): void
    {
        $this->comments = $this->post->comments()
            ->latest()
            ->get();
    }
}
