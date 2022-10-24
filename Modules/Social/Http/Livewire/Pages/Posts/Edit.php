<?php

namespace Modules\Social\Http\Livewire\Pages\Posts;

use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use Modules\Social\Models\Mention;
use Modules\Social\Models\Post;
use Phuclh\MediaManager\WithMediaManager;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Edit extends Component
{
    use WithMediaManager;

    public Post $post;

    public ?string $content = null;

    public ?string $editorId = null;

    public array $config = [];

    public array $images = [];

    public bool $openState = false;

    protected function rules(): array
    {
        return [
            'post.body'  => ['required', 'min:50'],
            'post.image' => ['nullable','string'],
        ];
    }

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->content = $this->post->body;
    }

    public function updatePost()
    {
        $validated = $this->validate()['post'];

        $this->post->update([
            'body' => Mention::processMentionContent($validated['body']),
        ]);

        $this->post->fresh();

        [$userMentions, $teamMentions] = Mention::getAllMentions($validated['body']);

        Mention::createManyFromHandles($userMentions, User::class, $this->post);
        Mention::createManyFromHandles($teamMentions, Team::class, $this->post);

        $this->redirectRoute('posts.show', $this->post);
    }

    public function setImage($image)
    {
        array_push($this->images, $image['url']);

        $this->emitImagesSet();
    }

    public function removeTemporaryImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
        }

        $this->emitImagesSet();
    }

    private function emitImagesSet(): void
    {
        $this->dispatchBrowserEvent('update-post:image-set', [
            'id'     => $this->editorId,
            'images' => $this->images
        ]);
    }

    public function removeImage(Media $media)
    {
        $media->delete();

        // emitto specific?
        //$this->removeFileFromMediaManager();
    }

    public function render()
    {
        return view('social::livewire.pages.posts.edit');
    }
}
