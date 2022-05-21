<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Phuclh\MediaManager\WithMediaManager;
use Spatie\Tags\Tag;

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
            'url'   => ['url', 'max:255'],
            'body'  => ['required', 'max:500'],
            'image' => ['nullable','string'],
        ];
    }

    public function addResource()
    {
        $validated = $this->validate();

        $hashtags = $this->pullTags($validated['body']);

        $resource = (new CreateNewPostAction)
            ->type(PostType::RESOURCE)
            ->execute($validated['body'], [
                'title' => $validated['title'],
                'url'   => $validated['url'],
                'image' => $validated['image']
            ]);

        $tags = $this->getTags($hashtags);
        $tags = $this->addResourceTag($tags);
        $resource->attachTags($tags);

        $this->reset('title', 'url', 'body', 'image');
        $this->redirectRoute('resources.home', $resource);
    }

    // Add Resource tag to all resources
    public function addResourceTag($tags) : array
    {
        if (!array_key_exists('resource', $tags)) {
            $tags[] = 'resource';
        }

        return $tags;
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

    public function pullTags($text)
    {
        $regexForHashtags = "/\B#([a-z0-9_-]+)/i";
        $hashtags = array();

        preg_match_all($regexForHashtags, $text, $hashtags);

        return $hashtags[1];
    }

    public function getTags($hashtags)
    {
        $tags = array();

        foreach ($hashtags as $hashtag) {
            $tags[] = Tag::findOrCreateFromString($hashtag);
        }

        return $tags;
    }

    public function render()
    {
        return view('resources::livewire.pages.resources.create');
    }
}
