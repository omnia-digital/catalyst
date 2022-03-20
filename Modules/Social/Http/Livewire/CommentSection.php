<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Models\Post;
use Modules\Social\Support\Livewire\WithPostEditor;

class CommentSection extends Component
{
    use WithPostEditor;

    public Post $post;

    protected $listeners = [
        'post-editor:submitted' => 'saveComment'
    ];

    public ?string $content = null;

    public function mount(Post $post)
    {
        $this->post = $post;

        dd($this->post->comments()->get()->toArray());
    }

    public function saveComment($data)
    {
        $this->content = strip_tags($data['content']);

        $this->validatePostEditor();

        (new CreateNewPostAction)
            ->asComment($this->post)
            ->execute($data['content']);

        $this->emitPostSaved();
    }

    public function render()
    {
        return view('social::livewire.comment-section');
    }
}
