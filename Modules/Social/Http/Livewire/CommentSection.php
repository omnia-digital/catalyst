<?php

namespace Modules\Social\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Modules\Social\Support\Livewire\WithPostEditor;

class CommentSection extends Component
{
    use WithPostEditor;

    public Post $post;

    public Collection $comments;

    public PostType $type;

    public ?string $content = null;

    protected $listeners = [
        'post-editor:submitted' => 'saveComment'
    ];

    public function mount(Post $post, ?PostType $type = null)
    {
        $this->post = $post;
        $this->type = $type;

        $this->loadComments();
    }

    public function saveComment($data)
    {
        $this->content = strip_tags($data['content']);

        $this->validatePostEditor();

        (new CreateNewPostAction)
            ->asComment($this->post)
            ->type($this->type)
            ->execute($data['content']);

        $this->loadComments();
        $this->emitPostSaved();
    }

    private function loadComments(): void
    {
        $this->comments = $this->post->comments()
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('social::livewire.comment-section');
    }
}
