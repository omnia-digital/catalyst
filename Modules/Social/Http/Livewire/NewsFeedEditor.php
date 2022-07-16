<?php

namespace Modules\Social\Http\Livewire;

use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Support\Livewire\WithPostEditor;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class NewsFeedEditor extends Component
{
    use WithPostEditor, WithNotification;

    public ?string $content = null;

    protected $listeners = [
        'post-editor:submitted' => 'createPost'
    ];

    public Team|null $team = null;

    public function createPost($data)
    {
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
        return view('social::livewire.news-feed-editor');
    }
}
