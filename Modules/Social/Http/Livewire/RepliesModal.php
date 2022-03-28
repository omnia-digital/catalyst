<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Models\Post;
use Modules\Social\Support\Livewire\WithPostEditor;

class RepliesModal extends Component
{
    use WithPostEditor;

    public int $replyCount = 0;

    public Post $post;

    public bool $show;

    public ?string $content = null;

    protected $listeners = [
        'postAdded',
        'post-editor:submitted' => 'saveComment'
    ];

    public function postAdded()
    {
        $this->replyCount = $this->post->comments()->count();
    }

    public function mount($post, $show = false)
    {
        $this->post = $post;
        $this->replyCount = $post->comments()->count();
        $this->show = $show;
    }

    public function saveComment($data)
    {
        $this->content = strip_tags($data['content']);

        $this->validatePostEditor();

        (new CreateNewPostAction)
            ->asComment($this->post)
            ->execute($data['content']);

        $this->emitPostSaved();
        $this->redirectRoute('social.posts.show', $this->post);
    }

    public function render()
    {
        return view('social::livewire.replies-modal');
    }
}
