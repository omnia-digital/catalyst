<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;

class PostEditor extends Component
{
    public ?string $content = null;

    public ?string $editorId = null;

    public array $config = [];

    public array $images = [];

    protected $listeners = [
        'validationFailed' => 'handleValidationFailed',
        'postSaved'        => 'handlePostSaved'
    ];

    public function mount(?string $editorId = null, array $config = [])
    {
        $this->editorId = $editorId;
        $this->config = $config;
    }

    public function submit()
    {
        $this->emitUp('post-editor:submitted', [
            'id'      => $this->editorId,
            'content' => $this->content,
            'images'  => $this->images
        ]);
    }

    public function handleValidationFailed($errorBag)
    {
        $this->setErrorBag($errorBag);
    }

    public function handlePostSaved()
    {
        $this->reset('content', 'images');
    }

    public function setImage($image)
    {
        array_push($this->images, $image['url']);
    }

    public function render()
    {
        return view('social::livewire.post-editor');
    }
}
