<?php namespace App\Http\Livewire\Channel;

use App\Models\Channel;
use App\Models\Player;
use App\Support\Episode\WithEpisodeList;
use Livewire\Component;

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
            'episodes' => $this->episodes
        ])->layout('layouts.guest');
    }
}
