<?php

namespace Modules\Livestream\Http\Livewire\Episode;

use Modules\Livestream\Models\Episode;
use Modules\Livestream\Support\Livewire\WithNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

/**
 * @property array $organizations
 */
class DeleteMultipleEpisodes extends Component
{
    use WithNotification, AuthorizesRequests;

    public bool $deleteMultipleEpisodesModalOpen = false;

    public array $episodeIDs;

    public bool $loading = false;

    protected $listeners = [
        'episodes-deleted'    => 'handleEpisodesDeleted'
    ];
    protected function rules(): array
    {
        return [];
    }

    public function deleteEpisodes()
    {
        $this->loading = true;

        foreach (Episode::whereIn('id', $this->episodeIDs)->get() as $episode) {
            if ($episode->video?->isProcessing()) continue;

            // Only soft-delete episode
            $episode->delete();

        }

        $this->success('Your episodes were deleted successfully!');
        $this->loading = false;
        $this->redirectRoute('episodes');
    }

    public function render()
    {
        return view('episode.delete-multiple-episodes');
    }
}
