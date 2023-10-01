<?php

namespace Modules\Social\Http\Livewire\Partials;

use App\Support\Platform\WithGuestAccess;
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
    use WithGuestAccess, WithModal, WithNotification, WithPostEditor;

    public Post $model;

    public ?string $content = null;

    public function showRepostModal(): void
    {
        $this->openModal('repost-modal-' . $this->model->id);
    }

    /**
     * @throws \Throwable
     */
    #[On('post-editor:submitted')]
    public function createRepost($data): void
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

        $this->model->user->notify(new PostWasRepostedNotification($repost, auth()->user()));

        $this->emitPostSaved($data['id']);
        $this->closeModal('repost-modal-' . $this->model->id);
        $this->redirectRoute('social.posts.show', $repost);
    }

    public function render()
    {
        return view('social::livewire.partials.repost-button');
    }
}
