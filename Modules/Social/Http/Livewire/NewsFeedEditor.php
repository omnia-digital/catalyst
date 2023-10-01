<?php

namespace Modules\Social\Http\Livewire;

use App\Models\Team;
use App\Support\Platform\Platform;
use App\Support\Platform\WithGuestAccess;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Modules\Social\Support\Livewire\WithPostEditor;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use Throwable;

class NewsFeedEditor extends Component
{
    use WithGuestAccess, WithNotification, WithPostEditor;

    public ?string $content = null;
    public ?PostType $postType;
    public string $submitButtonText = 'Post';
    public string $placeholder = "What\'s on your mind?";

    public ?Team $team = null;

    /**
     * @throws Throwable
     */
    #[On('post-editor:submitted')]
    public function createPost($editorId, $content, $images): void
    {
        if (Platform::isAllowingGuestAccess() && ! auth()->check()) {
            $this->showAuthenticationModal();

            return;
        }

        $this->content = strip_tags($content);

        $this->validatePostEditor();

        DB::transaction(function () use ($content, $images) {
            $options = [];
            if (! empty($this->team)) {
                $options['team_id'] = $this->team->id;
            }
            $post = (new CreateNewPostAction);
            if (! empty($this->postType)) {
                $post->type($this->postType);
            }
            $options['published_at'] = now();
            $post = $post->execute($content, $options);
            $post->attachMedia($images ?? []);
        });

        $this->emitPostSaved($editorId);
        $this->success('Post is created successfully!');
    }

    public function render()
    {
        return view('social::livewire.components.news-feed-editor');
    }
}
