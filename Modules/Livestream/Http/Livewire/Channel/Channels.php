<?php

namespace Modules\Livestream\Http\Livewire\Channel;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;
use Modules\Livestream\Support\Livewire\WithNotification;

/**
 * @property LivestreamAccount $livestreamAccount
 * @property Collection $players
 */
class Channels extends Component
{
    use WithLivestreamAccount, WithNotification;

    public bool $createChannelModalOpen = false;

    public string $name = '';

    public string|int $player = '';

    public function createChannel()
    {
        $validated = $this->validate();

        $this->livestreamAccount->channels()->create([
            'name' => $validated['name'],
            'player_id' => $validated['player'],
        ]);

        $this->reset('createChannelModalOpen', 'name', 'player');

        $this->success('Create channel successfully!');
    }

    public function getPlayersProperty()
    {
        return $this->livestreamAccount->players()
            ->latest()
            ->pluck('name', 'id');
    }

    public function render()
    {
        $channels = $this->livestreamAccount->channels()
            ->with('player')
            ->latest()
            ->get();

        return view('channel.channels', [
            'channels' => $channels,
            'players' => $this->players->all(),
        ]);
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'max:254'],
            'player' => ['required', Rule::in($this->players->keys())],
        ];
    }
}
