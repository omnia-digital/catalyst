<?php

namespace Modules\Livestream\Http\Livewire\Episode;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Livestream\Models\Category;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;
use Modules\Livestream\Support\Livewire\WithModal;
use Modules\Livestream\Support\Livewire\WithNotification;
use Modules\Livestream\Support\Livewire\WithSlideOver;
use Modules\Livestream\Support\Series\WithSeries;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ValidationRules\Rules\Delimited;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

/**
 * @property LivestreamAccount $livestreamAccount
 */
class EpisodeInfoPanel extends Component
{
    use WithFileUploads, WithNotification, AuthorizesRequests, WithSlideOver, WithLivestreamAccount, WithSeries, WithModal;

    public ?Episode $episode = null;

    public bool $isDetailPage = false;

    public $thumbnail;

    public array $state = [];

    public ?string $topics = null;

    public bool $editModalOpen = false;

    public array $selectedSeries = [];

    public null|int|string $deletingAttachment = null;

    protected $listeners = [
        'episodeSelected' => 'findEpisode',
        'episode-deselected' => 'resetEpisode',
        'attachmentUploaded' => '$refresh',
    ];

    public function mount($episodeId = null)
    {
        $this->isDetailPage = request()->routeIs('episodes.show');

        $this->findEpisode($episodeId);

        // Only check view permission on the detail page
        if ($episodeId) {
            $this->authorize('view', $this->episode);
        }
    }

    public function findEpisode($episodeId)
    {
        // Don't do anything when user select same episode.
        if ($episodeId === $this->episode?->id) {
            return;
        }

        $this->episode = Episode::withCount('videoViews')->find($episodeId);
        $this->selectedSeries = $this->episode->series()->pluck('series_id')->all();

        // Fill data for the edit form,
        // we don't want to use the data from model binding
        // because it will show title as empty when user delete title in the edit form.
        $this->state = $this->episode?->only([
            'title',
            'description',
            'date_recorded',
            'is_published',
            'main_speaker_id',
            'main_passage',
            'other_passages',
            'category_id',
        ]) ?? [];

        $this->topics = $this->episode->tagsWithType('topic')->implode('name', ',');

        // Dispatch event for open the over-slide on mobile
        $this->showSlideOver();
    }

    public function showEditModal()
    {
        $this->editModalOpen = true;
    }

    public function showDeleteAttachmentModal($mediaUuid)
    {
        $this->deletingAttachment = $mediaUuid;

        $this->showModal('confirm-delete-attachment');
    }

    public function updateEpisode()
    {
        $this->authorize('update', $this->episode);

        if (empty($this->state['is_published'])) {
            $this->state['is_published'] = false;
        }

        $this->validate();

        if ($this->thumbnail) {
            $this->state['thumbnail'] = $this->thumbnail->store('/thumbnails', 'episodes');
        }

        $this->episode->update($this->state);
        $this->episode->series()->sync($this->selectedSeries);
        $this->episode->syncTopics($this->topics);

        $this->episode->refresh();

        $this->success('Update episode successfully!');
        $this->hideEditModal();
    }

    public function hideEditModal()
    {
        $this->editModalOpen = false;
    }

    public function downloadEpisode()
    {
        $this->authorize('download', $this->episode);

        if (!($url = $this->episode->video->getDownloadUrl())) {
            $this->error('Converting file to be able to be downloaded. The time this process takes depends on the length of the video. If the video is over 1 hour long, please check back in a few hours.');

            return;
        }

        $this->redirect($url);
    }

    public function resetEpisode()
    {
        $this->reset('episode');
    }

    public function downloadAttachment($mediaUuid)
    {
        $media = Media::findByUuid($mediaUuid);

        if (!$media) {
            $this->error('Cannot find the attachment object.');

            return;
        }

        try {
            $file = Storage::disk('episode-attachments')
                ->getDriver()
                ->readStream('/' . $media->id . '/' . $media->file_name);

            return Response::stream(fn() => fpassthru($file), 200, [
                'Content-Type' => $media->mime_type,
                'Content-Disposition' => 'attachment; filename="' . $media->name . '"',
                'Content-Length' => $media->size,
            ]);
        } catch (Exception $e) {
            if ($e instanceof FileNotFoundException) {
                $this->error('Cannot find the attachment from server.');

                return;
            }

            report($e);
        }
    }

    public function deleteAttachment($mediaUuid)
    {
        $media = Media::findByUuid($mediaUuid);

        if (!$media) {
            $this->error('Cannot find the attachment object.');

            return;
        }

        $media->delete();
        $this->success('Delete attachment successfully!');
        $this->closeModal('confirm-delete-attachment');

        // We need to refresh the episode here
        // to clear the deleted attachment from cache.
        $this->episode->refresh();
    }

    public function getSpeakersProperty()
    {
        return $this->livestreamAccount
            ->team
            ->people
            ->pluck('name', 'id')
            ->all();
    }

    public function getCategoriesProperty()
    {
        return Category::query()
            ->pluck('name', 'id')
            ->all();
    }

    public function render()
    {
        return view('episode.episode-info-panel', [
            'attachments' => $this->episode?->getMedia()->sortBy('mime_type'),
            'staticAttachments' => $this->episode?->getStaticUrlMediaOnly()->sortBy('mime_type'),
            'series' => $this->series,
            'speakers' => $this->speakers,
            'categories' => $this->categories,
        ]);
    }

    protected function rules(): array
    {
        return [
            'state.title' => ['required', 'max:254'],
            'state.is_published' => ['required', 'bool'],
            'state.description' => ['nullable'],
            'state.date_recorded' => ['required'],
            'state.main_speaker_id' => ['nullable', Rule::in(array_keys($this->speakers))],
            'state.main_passage' => ['nullable', 'max:254'],
            'state.other_passages' => ['nullable'],
            'state.category_id' => ['nullable', Rule::in(array_keys($this->categories))],
            'topics' => ['nullable', new Delimited('string')],
            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'selectedSeries' => ['nullable'],
        ];
    }
}
