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

    /**
     * @return string[]
     *
     * @psalm-return array<string, 'handlePostSaved'|'handleValidationFailed'>
     */
    protected function getListeners()
    {
        return [
            'validationFailed:' . $this->editorId => 'handleValidationFailed',
            'postSaved:' . $this->editorId        => 'handlePostSaved'
        ];
    }

    public function mount(?string $editorId = null, array $config = []): void
    {
        $this->editorId = $editorId ?? uniqid();
        $this->config = $config;
    }

    public function submit(): void
    {
        $this->emitUp('post-editor:submitted', [
            'id'      => $this->editorId,
            'content' => $this->content,
            'images'  => $this->images
        ]);
    }

    public function handleValidationFailed($errorBag): void
    {
        $this->setErrorBag($errorBag);
    }

    public function handlePostSaved(): void
    {
        $this->reset('content', 'images');

        $this->emitImagesSet();
    }

    public function setImage($image): void
    {
        array_push($this->images, $image['url']);

        $this->emitImagesSet();
    }

    public function removeImage($index): void
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
        }

        $this->emitImagesSet();
    }

    private function emitImagesSet(): void
    {
        $this->dispatchBrowserEvent('post-editor:image-set', [
            'id'     => $this->editorId,
            'images' => $this->images
        ]);
    }

    public function render(): \Illuminate\View\View
    {
        return view('social::livewire.components.post-editor');
    }
}
