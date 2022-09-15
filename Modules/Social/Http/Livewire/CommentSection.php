<?php

namespace Modules\Social\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\NewCommentNotification;
use Modules\Social\Support\Livewire\WithPostEditor;

class CommentSection extends Component
{
    use WithPostEditor;

    public Post $post;

    public Collection $comments;

    public ?PostType $type = null;

    public ?string $content = null;

    protected $listeners = [
        'post-editor:submitted' => 'saveComment'
    ];

    public function mount(Post $post, $type = null)
    {
        $this->post = $post;
        $this->type = $type;

        $this->loadComments();
    }

    public function saveComment($data)
    {
        $this->content = strip_tags($data['content']);

        $this->validatePostEditor();

        $comment = DB::transaction(function () use ($data) {
            $comment = (new CreateNewPostAction)
                ->asComment($this->post)
                ->type($this->type)
                ->execute($data['content']);

            $comment->attachMedia($data['images'] ?? []);

            return $comment;
        });

        $this->post->user->notify(new NewCommentNotification($comment, Auth::user()));

        $this->loadComments();
        $this->emitPostSaved($data['id']);
    }

    private function loadComments(): void
    {
        $this->comments = $this->post->comments()
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('social::livewire.partials.comment-section');
    }
}
