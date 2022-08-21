<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;

class PostEditor extends Component
{


    public ?string $editorId = null;

    public array $images = [];

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

    private function emitImagesSet(): void
    {
        $this->dispatchBrowserEvent('post-editor:image-set', [
            'id'     => $this->editorId,
            'images' => $this->images
        ]);
    }
}
