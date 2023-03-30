<?php

namespace Modules\Livestream\Http\Livewire\Playlist;

use Livewire\Component;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;

/**
 * @property LivestreamAccount $livestreamAccount
 */
class Playlists extends Component
{
    use WithLivestreamAccount;

    public bool $createPlaylistModalOpen = false;

    public ?string $name = null;

    public function createPlaylist()
    {
        $validated = $this->validate();

        $playlist = $this->livestreamAccount->playlists()->create($validated);

        $this->redirectRoute('playlists.update', $playlist);
    }

    public function getRowsQueryProperty()
    {
        return $this->livestreamAccount
            ->playlists()
            ->latest();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(25);
    }

    public function render()
    {
        return view('playlist.playlists', [
            'playlists' => $this->rows,
        ]);
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:254'],
        ];
    }
}