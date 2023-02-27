<?php

namespace App\Http\Livewire\Channel;

use App\Models\Channel;
use App\Models\LivestreamAccount;
use App\Support\Livestream\WithLivestreamAccount;
use App\Support\Livewire\WithNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

/**
 * @property LivestreamAccount $livestreamAccount
 * @property Collection $players
 */
class UpdateChannel extends Component
{
    use WithLivestreamAccount, WithNotification, AuthorizesRequests;

    public Channel $channel;

    public bool $deleteChannelModalOpen = false;

    protected function rules()
    {
        return [
            'channel.name'      => ['required', 'max:254'],
            'channel.player_id' => ['required', Rule::in($this->players->keys())]
        ];
    }

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
            'players' => $this->players
        ]);
    }
}
