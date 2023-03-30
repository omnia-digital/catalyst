<?php

namespace Modules\Livestream\Http\Livewire\Episode;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Support\Livewire\WithNotification;

/**
 * @property array $organizations
 */
class DeleteEpisode extends Component
{
    use WithNotification, AuthorizesRequests;

    public bool $deleteEpisodeModalOpen = false;

    public Episode $episode;

    public bool $loading = false;

    protected $listeners = [
        'episode-deleted' => 'handleEpisodeDeleted',
    ];

    public function deleteEpisode()
    {
        $this->loading = true;
        $this->authorize('delete', $this->episode);

        if ($this->episode->video?->isProcessing()) {
            $this->error('This video is processing so you cannot delete it right now.');
            $this->loading = false;

            return;
        }

        // Only soft-delete episode
        $this->episode->delete();

        $this->success('Your episode is deleted successfully!');
        $this->loading = false;
        $this->redirectRoute('episodes');
    }

    public function render()
    {
        return view('episode.delete');
    }

    protected function rules(): array
    {
        return [];
    }
}
