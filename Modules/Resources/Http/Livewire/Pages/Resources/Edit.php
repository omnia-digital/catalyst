<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use Livewire\Component;
use Modules\Social\Models\Post;
use Phuclh\MediaManager\WithMediaManager;

class Edit extends Component
{
    use WithMediaManager;

    public ?string $title = null;

    public ?string $body = null;

    public ?string $url = null;

    public ?string $image = null;

    public ?Post $resource;

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

    public function openEditResourceModal(Post $resource)
    {
        $this->resource = $resource;

        $this->title = $this->resource->title;

        $this->body = $this->resource->body;

        $this->url = $this->resource->url;

        $this->dispatchBrowserEvent('edit-resource-modal', ['type' => 'open']);
    }

    public function updateResource()
    {
        $validated = $this->validate();

        $hashtags = $this->pullTags($validated['body']);

        $this->resource->update([
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
        ]);

        $tags = $this->getTags($hashtags);
        $this->resource->attachTags($tags, 'post');

        $this->reset('title', 'url', 'body', 'image', 'resource');
        $this->redirectRoute('resources.home', $this->resource);
    }

    public function confirmRemoval($media = null)
    {
        return;
    }

    public function render()
    {
        return view('resources::livewire.pages.resources.edit');
    }
}
