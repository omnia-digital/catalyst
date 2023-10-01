<?php

namespace Modules\Livestream\Http\Livewire\Player;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Modules\Livestream\Models\Player;
use Modules\Livestream\Support\Episode\WithEpisodeList;
use Modules\Livestream\Support\Livewire\WithNotification;
use Modules\Livestream\Support\Livewire\WithSlideOver;

class PlayerDetail extends Component
{
    use WithSlideOver, WithNotification, WithFileUploads, WithPagination, WithEpisodeList, AuthorizesRequests;

    public Player $player;

    public string $name = '';

    public $notLiveImage;

    public $beforeLiveImage;

    public ?string $currentNotLiveImage = null;

    public ?string $currentBeforeLiveImage = null;

    public bool $deletePlayerModalOpen = false;

    protected array $rules = [
        'name' => ['required', 'max:254'],
        'notLiveImage' => ['nullable', 'image', 'max:2048'],
        'beforeLiveImage' => ['nullable', 'image', 'max:2048'],
        'layout.columns' => ['required', 'integer', 'between:1,10'],
        'layout.video_per_page' => ['required', 'integer', 'between:1,25'],
        'layout.background_color' => ['required', 'string'],
    ];

    public function mount()
    {
        $this->authorize('view', $this->player);

        $this->name = $this->player->name;
        $this->currentNotLiveImage = $this->player->notliveImageUrl;
        $this->currentBeforeLiveImage = $this->player->beforeLiveImageUrl;
    }

    public function updatePlayer()
    {
        $this->authorize('update', $this->player);

        $this->validate(
            messages: [
                'layout.columns.required' => 'The Columns field must be required.',
                'layout.columns.integer' => 'The Columns field must be an integer.',
                'layout.columns.between' => 'The Columns field must be between 1-10.',
                'layout.video_per_page.required' => 'The Videos Per Page field must be required.',
                'layout.video_per_page.integer' => 'The Videos Per Page field must be an integer.',
                'layout.video_per_page.between' => 'The Videos Per Page field must be between 1-25.',
                'layout.background_color.required' => 'The Background Color field must be required.',
            ]
        );

        $this->player->update([
            'name' => $this->name,
            'layout' => $this->layout,
            'not_live_image' => $this->notLiveImage ? $this->notLiveImage->store('thumbnails',
                'players') : $this->currentNotLiveImage,
            'before_live_image' => $this->beforeLiveImage ? $this->beforeLiveImage->store('thumbnails',
                'players') : $this->currentBeforeLiveImage,
        ]);

        $this->hideSlideOver();
        $this->success('Update your player successfully!');
    }

    public function deletePlayer()
    {
        $this->authorize('delete', $this->player);

        $this->player->delete();

        $this->redirectRoute('players');
    }

    public function render()
    {
        return view('player.player-detail', [
            'episodes' => $this->episodes,
        ]);
    }
}
