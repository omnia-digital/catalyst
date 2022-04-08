<?php

namespace Modules\Resources\Http\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Modules\Social\Http\Livewire\PostListItem;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use function view;

class ResourceCard extends PostListItem
{
    use WithNotification;

    public ?string $title = null;

    public ?string $body = null;

    public ?string $url = null;

    public ?string $image = null;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'url'   => ['required', 'url', 'max:255'],
            'body'  => ['required', 'max:500'],
            'image' => ['required', 'max:255'],
        ];
    }

    public function addResource()
    {
        $validated = $this->validate();

        $resource = Auth::user()->currentTeam->resources()->create(
            array_merge($validated, ['user_id' => Auth::id()])
        );

        $this->reset('title', 'url', 'body', 'image');
        $this->redirectRoute('resources.show-resource', $resource);
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

    public function toggleBookmark()
    {
        if ($this->post->isBookmarked()) {
            $this->post->removeBookmark();
            $this->post->refresh();

            $this->success('Remove bookmark successfully!');

            return;
        }

        $this->post->markAsBookmark();
        $this->post->refresh();

        $this->success('Bookmark the resource successfully!');
    }

    public function render()
    {
        return view('resources::livewire.components.resource-card');
    }
}
