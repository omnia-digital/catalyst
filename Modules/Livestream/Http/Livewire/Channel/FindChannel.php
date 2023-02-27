<?php namespace App\Http\Livewire\Channel;

use App\Models\Channel;
use App\Support\Livewire\WithCachedRows;
use Livewire\Component;

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
            ->where('name', 'LIKE', "%$this->search%");
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
            'channels' => $this->search ? $this->rows : collect()
        ]);
    }
}
