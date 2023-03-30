<?php

namespace Modules\Social\Http\Livewire\Pages\Posts;

use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use Livewire\Component;
use Modules\Social\Models\Mention;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use Phuclh\MediaManager\WithMediaManager;
use Trans;

class Edit extends Component
{
    use WithMediaManager, WithNotification;

    public Post $post;

    public ?string $editorId = null;

    public array $config = [];

    public array $images = [];

    public bool $openState = false;

    public bool $confirmingMediaRemoval = false;

    public $mediaIdBeingRemoved = null;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->editorId = uniqid();
    }

    public function updatePost()
    {
        $validated = $this->validate()['post'];

        $this->post->update([
            'body' => Mention::processMentionContent($validated['body']),
        ]);

        $hashtags = Tag::parseHashTagsFromString($validated['body']);
        $tags = Tag::findOrCreateTags($hashtags, 'post');
        $this->post->attachTags($tags, 'post');

        $this->post->attachMedia($this->images);

        $this->post->fresh();

        [$userMentions, $teamMentions] = Mention::getAllMentions($validated['body']);

        Mention::createManyFromHandles($userMentions, User::class, $this->post);
        Mention::createManyFromHandles($teamMentions, Team::class, $this->post);

        $this->success('Post updated!');
        $this->redirectRoute('social.posts.show', $this->post);
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

    public function removeImage()
    {
        $this->post->media()->where('id', $this->mediaIdBeingRemoved)->delete();

        $this->post->fresh();

        $this->emit('refreshComponent');

        $this->reset('confirmingMediaRemoval', 'mediaIdBeingRemoved');

        $this->success(Trans::get('Image removed.'));
    }

    public function confirmMediaRemoval($mediaId)
    {
        $this->confirmingMediaRemoval = true;

        $this->mediaIdBeingRemoved = $mediaId;
    }

    public function getPostMediaProperty()
    {
        return $this->post->getMedia();
    }

    public function render()
    {
        return view('social::livewire.pages.posts.edit', [
            'postMedia' => $this->postMedia,
        ]);
    }

    protected function rules(): array
    {
        return [
            'post.body' => ['required'],
            'post.image' => ['nullable', 'string'],
        ];
    }

    private function emitImagesSet(): void
    {
        $this->dispatchBrowserEvent('update-post:image-set', [
            'id' => $this->editorId,
            'images' => $this->images,
        ]);
    }
}
