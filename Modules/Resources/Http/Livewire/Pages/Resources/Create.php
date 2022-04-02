<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
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
            'url'   => ['url', 'max:255'],
            'body'  => ['required', 'max:500'],
            'image' => ['nullable','string'],
        ];
    }

    public function addResource()
    {
        $validated = $this->validate();

        $resource = (new CreateNewPostAction)
            ->type(PostType::RESOURCE)
            ->execute($validated['body'], [
                'title' => $validated['title'],
                'url'   => $validated['url'],
                'image' => $validated['image']
            ]);

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
