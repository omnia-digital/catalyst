<?php

namespace Modules\Livestream\Http\Livewire\Channel;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Livestream\Models\Channel;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;
use Modules\Livestream\Support\Livewire\WithNotification;

/**
 * @property LivestreamAccount $livestreamAccount
 * @property Collection $players
 */
class UpdateChannel extends Component
{
    use WithLivestreamAccount, WithNotification, AuthorizesRequests;

    public Channel $channel;

    public bool $deleteChannelModalOpen = false;

    public function mount()
    {
        $this->authorize('update', $this->channel);
    }

    public function updateChannel()
    {
        $this->authorize('update', $this->channel);

        $this->validate();

        $this->channel->save();

        $this->success('Update channel successfully!');
    }

    public function deleteChannel()
    {
        $this->authorize('delete', $this->channel);

        $this->channel->delete();

        $this->redirectRoute('channels');
    }

    public function getPlayersProperty()
    {
        return $this->livestreamAccount->players()
            ->latest()
            ->pluck('name', 'id');
    }

    public function render()
    {
        return view('channel.update-channel', [
            'players' => $this->players,
        ]);
    }

    protected function rules()
    {
        return [
            'channel.name' => ['required', 'max:254'],
            'channel.player_id' => ['required', Rule::in($this->players->keys())],
        ];
    }
}
