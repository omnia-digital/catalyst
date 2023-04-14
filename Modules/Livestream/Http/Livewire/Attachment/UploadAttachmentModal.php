<?php

namespace Modules\Livestream\Http\Livewire\Attachment;

use GuzzleHttp\Psr7\Uri;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Support\Livewire\WithNotification;

class UploadAttachmentModal extends Component
{
    use WithFileUploads, WithNotification;

    public Episode $episode;

    public bool $uploadAttachmentModalOpen = false;

    public bool $isUpload = true;

    public ?string $name = null;

    public TemporaryUploadedFile|string|null $attachment = null;

    public ?string $url = null;

    protected $listeners = [
        'uploadAttachmentShow' => 'showUploadAttachmentModal',
    ];

    public function updatedAttachment()
    {
        $this->validate($this->uploadRules());
    }

    public function showUploadAttachmentModal()
    {
        $this->uploadAttachmentModalOpen = true;
    }

    public function hideUploadAttachmentModal()
    {
        $this->uploadAttachmentModalOpen = false;
    }

    public function submit()
    {
        $rules = ['name' => ['nullable', 'max:254']];

        $rules = $this->isUpload
            ? array_merge($rules, $this->uploadRules())
            : array_merge($rules, ['url' => ['required', 'url']]);

        $this->validate($rules);

        $this->isUpload ? $this->upload() : $this->saveStaticUrl();

        $this->reset('name', 'attachment', 'url');
        $this->emit('clearUploadInput');
        $this->success('Upload attachment successfully');
        $this->hideUploadAttachmentModal();
        $this->emitTo('episode.episode-info-panel', 'attachmentUploaded');
    }

    public function render()
    {
        return view('attachment.upload-attachment-modal');
    }

    private function upload(): void
    {
        $this->episode
            ->addMediaFromUrl($this->attachment->temporaryUrl())
            ->usingName($this->name ?? $this->attachment->getClientOriginalName())
            ->toMediaCollection();
    }

    private function saveStaticUrl()
    {
        $mimeType = ltrim((new Uri($this->url))->getHost(), 'www.');

        $this->episode->saveStaticUrl($this->url, $this->name, $mimeType);
    }

    private function uploadRules(): array
    {
        return [
            'attachment' => [
                'mimes:' . implode(',', config('media-library.allowed_file_types')),
                'max:' . config('media-library.max_file_size'),
            ],
        ];
    }
}
