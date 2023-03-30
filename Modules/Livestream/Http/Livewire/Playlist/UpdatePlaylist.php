<?php

namespace Modules\Livestream\Http\Livewire\Playlist;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Livestream\Models\Playlist;
use Modules\Livestream\Support\Livewire\WithNotification;

class UpdatePlaylist extends Component
{
    use WithNotification, AuthorizesRequests;

    public Playlist $playlist;

    public bool $deletePlaylistModalOpen = false;

    public function mount()
    {
        $this->authorize('update', $this->playlist);
    }

    public function updatePlaylist()
    {
        $this->authorize('update', $this->playlist);

        $this->validate();

        $this->playlist->save();

        $this->success('Update playlist successfully!');
    }

    public function deletePlaylist()
    {
        $this->authorize('delete', $this->playlist);

        $this->playlist->delete();

        $this->redirectRoute('playlists');
    }

    public function render()
    {
        return view('playlist.update-playlist');
    }

    protected function rules(): array
    {
        return [
            'playlist.name' => ['required', 'max:254'],
            'playlist.per_page' => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }
}
