<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Social\Models\Attachment;

class AttachmentDrawer extends Component
{
    use WithFileUploads;

    public $attached_files = [];
    public $attachments = [];

    public function updatedAttachedFiles()
    {
        $validatedFiles = $this->validate([
            'attached_files' => 'array',
            'attached_files.*' => 'file|max:2048',
        ]);

        foreach ($validatedFiles['attached_files'] as $file) {
            $path = $file->store('post-attachments');

            if (! $path) {
                // throw some error
            }

            $this->attachments[] = Attachment::firstOrNew(
                ['name' => $file->hashName()],
                [
                    'extension' => $file->extension(),
                    'size' => $file->getSize(),
                ]
            );
        }

        $this->emitUp('filesAdded', $this->attachments);
    }

    public function render()
    {
        return view('social::livewire.partials.attachment-drawer');
    }
}
