<?php

namespace App\Http\Livewire\Playlist;

use App\Models\LivestreamAccount;
use App\Support\Livestream\WithLivestreamAccount;
use Livewire\Component;

/**
 * @property LivestreamAccount $livestreamAccount
 */
class Playlists extends Component
{
    use WithLivestreamAccount;

    public bool $createPlaylistModalOpen = false;

    public ?string $name = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:254']
        ];
    }

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
            'playlists' => $this->rows
        ]);
    }
}
