<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;

class PostEditor extends Component
{
    public ?string $content = null;

    public ?string $editorId = null;

    public array $config = [];

    public string $placeholderText = "Write something...";

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
        ]);
    }

    public function handleValidationFailed($errorBag)
    {
        $this->setErrorBag($errorBag);
    }

    public function handlePostSaved()
    {
        $this->reset('content');
    }

    public function render()
    {
        return view('social::livewire.post-editor');
    }
}
