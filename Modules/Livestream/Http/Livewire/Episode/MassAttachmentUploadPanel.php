<?php

namespace Modules\Livestream\Http\Livewire\Episode;

use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Support\Livewire\WithNotification;

class MassAttachmentUploadPanel extends Component
{
    use WithFileUploads, WithNotification;

    public $massAttachments = [];

    public $viewReport = false;
    public $reportHtml = '';

    public $uploadedContent = [];

    public function process()
    {
        $this->validate([
            'massAttachments.*' => [
                'mimes:' . implode(',', config('media-library.allowed_file_types')),
                'max:' . config('media-library.max_file_size'),
            ],
        ]);

        // Loop through each file
        foreach ($this->massAttachments as $attachment) {
            [$title, $ext] = explode('.', $attachment->getClientOriginalName());

            // Find the episode associated with that file
            $fileName = '%' . implode('%', explode(' ', $title)) . '%';

            $episode = Episode::where('title', 'like', $fileName)->first();

            if (is_null($episode)) {
                continue;
            }

            // Check if the episode has a file with the same extension
            $sameExtensionExists = $episode->media()->where('file_name', 'like', '%' . $ext . '%')->exists();

            // Check if the episode has a file name with the same title
            $sameNameExists = $episode->media()->where('name', 'like', $fileName)->exists();

            if (! $sameExtensionExists || ! $sameNameExists) {
                // If not, add that attachment
                $mediaItem = $episode->addMediaFromUrl($attachment->temporaryUrl())
                    ->usingName($title)
                    ->toMediaCollection();

                $this->uploadedContent[] = [
                    'epId' => $episode->id,
                    'epTitle' => $episode->title,
                    'mediaItem' => "<strong>{$ext}:</strong> {$mediaItem->name}",
                ];
            }
        }

        $this->reset('massAttachments');
        $this->dispatch('clearUploadInput');
        $this->success('Uploaded attachments successfully');
    }

    public function openReport()
    {
        if (empty($this->uploadedContent)) {
            $this->error('Nothing to show');

            return;
        }

        $this->getReport();

        $this->viewReport = true;
    }

    public function closeReport()
    {
        $this->viewReport = false;
    }

    public function getReport()
    {
        $this->reportHtml = <<<'REPORT'
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Episode ID</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Episode Title</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Uploaded Media</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
        REPORT;

        foreach ($this->uploadedContent as $item) {
            $this->reportHtml .= <<<REPORT
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{$item['epId']}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{$item['epTitle']}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{$item['mediaItem']}</td>
                </tr>
            REPORT;
        }

        $this->reportHtml .= <<<'REPORT'
                </tbody>
            </table>
        REPORT;

        Mail::html($this->reportHtml, function ($message) {
            return $message
                ->to(auth()->user()->email)
                ->cc('info@omniadigital.io')
                ->subject('Upload Report ' . now()->toFormattedDateString());
        });
    }

    public function render()
    {
        return view('episode.mass-attachment-upload-panel');
    }
}
