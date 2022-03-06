<?php

namespace Modules\Resources\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
//use Phuclh\MediaManager\WithMediaManager;

class AddResourceModal extends Component
{
//    use WithMediaManager;

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

    public function render()
    {
        return view('resources::livewire.add-resource-modal');
    }
}
