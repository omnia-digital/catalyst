<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;

class PostEditor extends Component
{
    public ?string $content = null;

    public ?string $editorId = null;

    public array $config = [];

    public array $images = [];

    public string $placeholder = "What\'s on your mind?";

    public string $submitButtonText = 'Post';

    public bool $includeTitle = false;

    public bool $openState = false;

    public function mount(?string $editorId = null, array $config = [])
    {
        $this->editorId = $editorId ?? uniqid();
        $this->config = $config;
    }

    public function submit()
    {
        $this->dispatch('post-editor:submitted',
            id: $this->editorId,
            content: $this->content,
            images: $this->images
        );
    }

    public function handleValidationFailed($errorBag)
    {
        $this->setErrorBag($errorBag);
    }

    public function handlePostSaved()
    {
        $this->reset('content', 'images');

        $this->emitImagesSet();
    }

    private function emitImagesSet(): void
    {
        $this->dispatch('post-editor:image-set',
            id: $this->editorId,
            images: $this->images
        );
    }

    public function setImage($image)
    {
        array_push($this->images, $image['url']);

        $this->emitImagesSet();
    }

    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
        }

        $this->emitImagesSet();
    }

    public function render()
    {
        return view('social::livewire.components.post-editor');
    }

    protected function getListeners()
    {
        return [
            'validationFailed:' . $this->editorId => 'handleValidationFailed',
            'postSaved:' . $this->editorId => 'handlePostSaved',
        ];
    }
}
