<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use App\Models\Tag;
use Livewire\Component;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Phuclh\MediaManager\WithMediaManager;

class Create extends Component
{
    use WithMediaManager;

    public ?string $title = null;

    public ?string $body = null;

    public ?string $url = null;

    public ?string $image = null;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'url'   => ['nullable', 'url', 'max:255'],
            'body'  => ['required', 'min:50'],
            'image' => ['nullable','string'],
        ];
    }

    public function addResource()
    {
        $validated = $this->validate();

        $hashtags = Tag::parseHashTagsFromString($validated['body']);

        $resource = (new CreateNewPostAction)
            ->type(PostType::RESOURCE)
            ->execute($validated['body'], [
                'title' => $validated['title'],
                'body' => $validated['body'],
                'url'   => $validated['url'],
            ]);

        $tags = Tag::findOrCreateTags($hashtags, 'post');
        $resource->attachTags($tags,'post');

        if (isset($validated['image'])) {
            $resource->attachMedia([$validated['image']]);
        }

        $this->reset('title', 'url', 'body', 'image');
        $this->redirectRoute('resources.home', $resource);
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

    public function render()
    {
        return view('resources::livewire.pages.resources.create');
    }
}
