<?php namespace App\Http\Livewire\Player;

use App\Models\LivestreamAccount;
use App\Support\Livestream\WithLivestreamAccount;
use App\Support\Livewire\WithNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * @property LivestreamAccount $livestreamAccount
 */
class Players extends Component
{
    use WithNotification, WithFileUploads, WithLivestreamAccount;

    public bool $createPlayerModalOpen = false;

    public string $name = '';

    public $notLiveImage;

    public $beforeLiveImage;

    protected array $rules = [
        'name'            => ['required', 'max:254'],
        'notLiveImage'    => ['nullable', 'image', 'max:2048'],
        'beforeLiveImage' => ['nullable', 'image', 'max:2048'],
    ];

    public function createPlayer()
    {
        $this->validate();

        Auth::user()->currentTeam->livestreamAccount->players()->create([
            'name'              => $this->name,
            'not_live_image'    => $this->notLiveImage ? $this->notLiveImage->store('thumbnails', 'players') : null,
            'before_live_image' => $this->beforeLiveImage ? $this->beforeLiveImage->store('thumbnails', 'players') : null
        ]);

        $this->reset('name', 'createPlayerModalOpen');
        $this->success('Create player successfully!');
    }

    public function render()
    {
        $players = $this->livestreamAccount->players()
            ->with('livestreamAccount')
            ->latest()
            ->get();

        return view('player.players', [
            'players' => $players
        ]);
    }
}
