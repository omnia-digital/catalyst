<?php

namespace Modules\Advice\Http\Livewire\Pages\Questions;

use Livewire\Component;
use Phuclh\MediaManager\WithMediaManager;

class Create extends Component
{
    use WithMediaManager;

    public ?string $title = null;

    public ?string $body = null;

    public ?string $url = null;

    public ?string $image = null;

    public function addResource()
    {
        $validated = $this->validate();

        $resource = auth()->user()->posts()->create(
            array_merge($validated, [
                'team_id' => auth()->user()->currentTeam->id,
                'type' => 'resource',
            ])
        );

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
        return view('advice::livewire.pages.questions.create');
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'url' => ['required', 'url', 'max:255'],
            'body' => ['required', 'max:500'],
            'image' => ['required', 'max:255'],
        ];
    }
}
