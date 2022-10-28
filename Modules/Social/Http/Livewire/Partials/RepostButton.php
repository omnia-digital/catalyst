<?php

namespace Modules\Social\Http\Livewire\Partials;

use App\Support\Platform\WithGuestAccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\PostWasRepostedNotification;
use Modules\Social\Support\Livewire\WithPostEditor;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class RepostButton extends Component
{
    use WithModal, WithNotification, WithPostEditor, WithGuestAccess;

    public Post $model;

    public ?string $content = null;

    protected $listeners = [
        'post-editor:submitted' => 'createRepost'
    ];

    public function showRepostModal()
    {
        $this->openModal('repost-modal-' . $this->model->id);
    }

    public function createRepost($data)
    {
        $this->content = strip_tags($data['content']);

        $this->validatePostEditor();

        /** @var Post $repost */
        $repost = DB::transaction(function () use ($data) {
            $repost = (new CreateNewPostAction)
                ->asRepost($this->model)
                ->execute($data['content']);

            $repost->attachMedia($data['images'] ?? []);

            return $repost;
        });


        $this->model->user->notify(new PostWasRepostedNotification($repost, Auth::user()));

        $this->emitPostSaved($data['id']);
        $this->closeModal('repost-modal-' . $this->model->id);
        $this->redirectRoute('social.posts.show', $repost);
    }

    public function render()
    {
        return view('social::livewire.partials.repost-button');
    }
}
