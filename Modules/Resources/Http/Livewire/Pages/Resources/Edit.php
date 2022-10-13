<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use App\Models\Tag;
use Livewire\Component;
use Modules\Social\Models\Mention;
use Modules\Social\Models\Post;
use Phuclh\MediaManager\WithMediaManager;

class Edit extends Component
{
    use WithMediaManager;

    public ?string $title = null;

    public ?string $body = null;

    public ?string $url = null;

    public ?string $image = null;

    public Post|null $resource;

    protected $listeners = ['openEditResourceModal'];

    protected function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'url'   => ['nullable', 'url', 'max:255'],
            'body'  => ['required', 'min:50'],
            'image' => ['nullable','string'],
        ];
    }

    public function mount(Post $resource = null)
    {
        if (!is_null($resource)) {
            $this->resource = $resource;
        }
    }

    public function openEditResourceModal($resourceID = null)
    {
        if (!is_null($resourceID)) {
            $this->resource = Post::find($resourceID);
        }

        $this->title = $this->resource->title;

        $this->body = $this->resource->body;

        $this->url = $this->resource->url;

        $this->dispatchBrowserEvent('edit-resource-modal', ['type' => 'open']);
    }

    public function updateResource()
    {
        $validated = $this->validate();

        $hashtags = Tag::pullTags($validated['body']);

        $this->resource->update([
            'title' => $validated['title'],
            'body' => Mention::processMentionContent(strip_tags($validated['body'])),
            'url' => $validated['url'],
            'image' => $validated['image']
        ]);

        $updatedResource = $this->resource;

        [$userMentions, $teamMentions] = Mention::getAllMentions($validated['body']);

        Mention::createManyFromHandles($userMentions, User::class, $updatedResource);
        Mention::createManyFromHandles($teamMentions, Team::class, $updatedResource);

        $tags = Tag::getTags($hashtags);
        $updatedResource->attachTags($tags, 'post');

        $this->reset('title', 'url', 'body', 'image');
        $this->redirectRoute('resources.show', $updatedResource);
    }

    public function setFeaturedImage(array $image)
    {
        $this->image = $image['url'];
    }

    public function removeFeaturedImage()
    {
        $this->image = null;

        $this->removeFileFromMediaManager();
    }

    public function removeImage()
    {
        if (is_null($this->resource)) return;

        $this->resource->image = null;
    }

    public function render()
    {
        return view('resources::livewire.pages.resources.edit');
    }
}
