<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Social\Models\Mention;
use Modules\Social\Models\Post;
use Omnia\MediaManager\WithMediaManager;

class Edit extends Component
{
    use WithMediaManager, AuthorizesRequests;

    public Post $resource;

    public array $tags = [];

    public function mount(Post $resource)
    {
        $this->resource = $resource;

        if (is_null($this->resource->published_at)) {
            // If it's a draft only the owner can view it
            $this->authorize('update', $this->resource);
        }
    }

    public function saveAsDraft()
    {
        $validated = $this->validate()['resource'];

        $this->saveResource($validated);

        if (! is_null($this->resource->published_at)) {
            $this->resource->published_at = null;
            $this->resource->save();
        }

        $this->addMentions($validated['body']);

        $this->addTags($validated['body']);

        if (isset($validated['image'])) {
            $this->resource->attachMedia([$validated['image']]);
        }

        $this->redirectRoute('resources.show', $this->resource);
    }

    public function publishResource()
    {
        $validated = $this->validate()['resource'];

        $this->saveResource($validated);

        if (is_null($this->resource->published_at)) {
            $this->resource->published_at = now();
            $this->resource->save();
        }

        $this->addMentions($validated['body']);

        $this->addTags($validated['body']);

        if (isset($validated['image'])) {
            $this->resource->attachMedia([$validated['image']]);
        }

        $this->redirectRoute('resources.show', $this->resource);
    }

    public function addMentions($content)
    {
        [$userMentions, $teamMentions] = Mention::getAllMentions($content);

        Mention::createManyFromHandles($userMentions, User::class, $this->resource);
        Mention::createManyFromHandles($teamMentions, Team::class, $this->resource);
    }

    public function addTags($content)
    {
        $hashtags = Tag::parseHashTagsFromString($content);

        $tags = Tag::findOrCreateTags($hashtags, 'post');

        $this->resource->attachTags($tags, 'post');
    }

    public function getResourceTagsProperty()
    {
        // get tags that aren't the resource tag since we don't want the user to edit that one
        $tagsToRemove = [
            'Resource'
        ];
        return $this->resource->tags->mapWithKeys(function (Tag $tag) {
            return [$tag->name => ucwords($tag->name)];
        })->pluck($tagsToRemove)->all();
    }

    public function saveResource($attributes)
    {
        $this->resource->update([
            'title' => $attributes['title'],
            'body' => Mention::processMentionContent($attributes['body']),
            'url' => $attributes['url'],
            'image' => $attributes['image'],
        ]);

        $this->resource->fresh();
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
        return view('resources::livewire.pages.resources.edit', [
            'resourceTags' => $this->resourceTags
        ]);
    }

    protected function rules(): array
    {
        return [
            'resource.title' => ['required', 'max:255'],
            'resource.url' => ['nullable', 'url', 'max:255'],
            'resource.body' => ['required', 'min:50'],
            'resource.image' => ['nullable', 'string'],
        ];
    }
}
