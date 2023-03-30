<?php

namespace Modules\Livestream\Http\Livewire\Channel;

use Livewire\Component;
use Modules\Livestream\Models\Channel;
use Modules\Livestream\Models\Player;
use Modules\Livestream\Support\Episode\WithEpisodeList;

class ChannelDetail extends Component
{
    use WithEpisodeList;

    public Channel $channel;

    public Player $player;

    public function mount()
    {
        $this->player = $this->channel->player;
    }

    public function render()
    {
        return view('channel.channel-detail', [
            'episodes' => $this->episodes,
        ])->layout('layouts.guest');
    }
}
