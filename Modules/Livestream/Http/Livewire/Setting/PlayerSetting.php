<?php

namespace Modules\Livestream\Http\Livewire\Setting;

use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;

/**
 * @property LivestreamAccount $livestreamAccount
 */
class PlayerSetting extends Component
{
    use WithLivestreamAccount, WithFileUploads;

    public $notLiveImage = null;

    public $beforeLiveImage = null;

    public ?string $currentNotLiveImage = null;

    public ?string $currentBeforeLiveImage = null;

    protected array $rules = [
        'notLiveImage' => ['nullable', 'image', 'max:2048'],
        'beforeLiveImage' => ['nullable', 'image', 'max:2048'],
    ];

    public function mount()
    {
        $this->currentNotLiveImage = $this->livestreamAccount->notLiveImageUrl;
        $this->currentBeforeLiveImage = $this->livestreamAccount->beforeLiveImageUrl;
    }

    public function updatePlayerSetting()
    {
        $this->validate();

        $this->livestreamAccount->update([
            'not_live_image' => $this->notLiveImage ? $this->notLiveImage->store('thumbnails', 'players') : $this->currentNotLiveImage,
            'before_live_image' => $this->beforeLiveImage ? $this->beforeLiveImage->store('thumbnails', 'players') : $this->currentBeforeLiveImage,
        ]);

        $this->emit('saved');
    }

    public function render()
    {
        return view('setting.player-setting')->layout('layouts.setting');
    }
}
