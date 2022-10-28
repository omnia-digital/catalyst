<?php

namespace Modules\Social\Http\Livewire;

use App\Models\Team;
use App\Support\Platform\Platform;
use App\Support\Platform\WithGuestAccess;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Support\Livewire\WithPostEditor;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class NewsFeedEditor extends Component
{
    use WithPostEditor, WithNotification, WithGuestAccess;

    public ?string $content = null;

    protected $listeners = [
        'post-editor:submitted' => 'createPost'
    ];

    public Team|null $team = null;

    public function createPost($data)
    {
        if (Platform::isAllowingGuestAccess() && !Auth::check()) {
            $this->showAuthenticationModal();

            return;
        }

        $this->content = strip_tags($data['content']);

        $this->validatePostEditor();

        DB::transaction(function () use ($data) {
            $options = [];
            if (!empty($this->team)) {
                $options['team_id'] = $this->team->id;
            }
            $post = (new CreateNewPostAction)->execute($data['content'], $options);
            $post->attachMedia($data['images'] ?? []);
        });

        $this->emitPostSaved($data['id']);
        $this->success('Post is created successfully!');
    }

    public function render()
    {
        return view('social::livewire.components.news-feed-editor');
    }
}
