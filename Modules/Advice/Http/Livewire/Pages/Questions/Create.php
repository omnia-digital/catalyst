<?php

namespace Modules\Advice\Http\Livewire\Pages\Questions;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
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
            'url'   => ['required', 'url', 'max:255'],
            'body'  => ['required', 'max:500'],
            'image' => ['required', 'max:255'],
        ];
    }

    public function addResource(): void
    {
        $validated = $this->validate();

        $resource = Auth::user()->posts()->create(
            array_merge($validated, [
                'team_id' => Auth::user()->currentTeam->id,
                'type'  => 'resource'
            ])
        );

        $this->reset('title', 'url', 'body', 'image');
        $this->redirectRoute('resources.home', $resource);
    }

    public function setFeaturedImage(array $image): void
    {
        $this->image = $image['url'];
    }

    public function removeFeaturedImage(): void
    {
        $this->image = null;

        $this->removeFileFromMediaManager();
    }

    public function render(): \Illuminate\View\View
    {
        return view('advice::livewire.pages.questions.create');
    }
}
