<?php

namespace Modules\Livestream\Http\Livewire\Channel;

use Livewire\Component;
use Modules\Livestream\Models\Channel;
use Modules\Livestream\Support\Livewire\WithCachedRows;

class FindChannel extends Component
{
    use WithCachedRows;

    public ?string $search = null;

    protected $queryString = ['search'];

    public function getRowsQueryProperty()
    {
        return Channel::query()
            ->has('livestreamAccount.episodes') // Only get channels have at least 1 episode.
            ->with(['livestreamAccount.team'])
            ->where('name', 'LIKE', "%{$this->search}%");
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(25);
        });
    }

    public function render()
    {
        return view('channel.find-channel', [
            'channels' => $this->search ? $this->rows : collect(),
        ]);
    }
}
