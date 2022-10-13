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

    public ?string $image = null;

    public Post $resource;

    protected $listeners = ['openEditResourceModal'];

    protected function rules(): array
    {
        return [
            'resource.title' => ['required', 'max:255'],
            'resource.url'   => ['nullable', 'url', 'max:255'],
            'resource.body'  => ['required', 'min:50'],
            'resource.image' => ['nullable','string'],
        ];
    }

    public function mount(Post $resource)
    {
        $this->resource = $resource;
    }

    public function updateResource()
    {
        $validated = $this->validate()['resource'];

        $hashtags = Tag::pullTags($validated['body']);

        $this->resource->update([
            'title' => $validated['title'],
            'body' => Mention::processMentionContent(strip_tags($validated['body'])),
            'url' => $validated['url'],
            'image' => $validated['image']
        ]);

        $this->resource->fresh();

        [$userMentions, $teamMentions] = Mention::getAllMentions($validated['body']);

        Mention::createManyFromHandles($userMentions, User::class, $this->resource);
        Mention::createManyFromHandles($teamMentions, Team::class, $this->resource);

        $tags = Tag::getTags($hashtags);
        $this->resource->attachTags($tags, 'post');

        $this->redirectRoute('resources.show', $this->resource);
    }

    public function setFeaturedImage(array $image)
    {
        $this->resource->image = $image['url'];
    }

    public function removeFeaturedImage()
    {
        $this->resource->image = null;

        $this->removeFileFromMediaManager();
    }

    public function render()
    {
        return view('resources::livewire.pages.resources.edit');
    }
}
