<?php

namespace Modules\Social\Http\Livewire;

use App\Support\Platform\WithLoginModal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\NewCommentNotification;
use Modules\Social\Support\Livewire\WithPostEditor;

class RepliesModal extends Component
{
    use WithPostEditor, WithLoginModal;

    public int $replyCount = 0;

    public Post $post;

    public bool $show;

    public ?PostType $type = null;

    public ?string $content = null;

    protected $listeners = [
        'postAdded',
        'post-editor:submitted' => 'saveComment'
    ];

    public function postAdded()
    {
        $this->replyCount = $this->post->comments()->count();
    }

    public function mount($post, $show = false, $type = null)
    {
        $this->post = $post;
        $this->replyCount = $post->comments()->count();
        $this->show = $show;
        $this->type = $type;
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

        $this->emitPostSaved($data['id']);
        $this->redirectRoute('social.posts.show', $this->post);
    }

    public function render()
    {
        return view('social::livewire.partials.replies-modal');
    }
}
