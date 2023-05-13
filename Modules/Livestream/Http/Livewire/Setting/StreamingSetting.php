<?php

namespace Modules\Livestream\Http\Livewire\Setting;

use Livewire\Component;
use Modules\Livestream\Actions\Livestream\CreateMuxStreamAction;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;

/**
 * @property LivestreamAccount $livestreamAccount
 */
class StreamingSetting extends Component
{
    use WithLivestreamAccount;

    public array $streaming = [];

    protected array $rules = [
        'streaming.cdn_playback_url' => ['nullable', 'url'],
        'streaming.mux_livestream_active' => ['nullable', 'boolean'],
        'streaming.mux_vod_active' => ['nullable', 'boolean'],
        'streaming.mux_stream_targets_active' => ['nullable', 'boolean'],
    ];

    public function mount()
    {
        $this->streaming = [
            'cdn_playback_url' => $this->livestreamAccount->cdn_playback_url,
            'mux_livestream_active' => $this->livestreamAccount->mux_livestream_active,
            'mux_vod_active' => $this->livestreamAccount->mux_vod_active,
            'mux_stream_targets_active' => $this->livestreamAccount->mux_stream_targets_active,
        ];
    }

    public function updateStreamingSetting()
    {
        $validated = $this->validate();

        $this->livestreamAccount->update($validated['streaming']);

        if ($this->streaming['mux_livestream_active'] && ! $this->livestreamAccount->hasDefaultStream()) {
            (new CreateMuxStreamAction)->execute($this->livestreamAccount->team);
        }

        $this->emit('saved');
    }

    public function render()
    {
        return view('setting.streaming-setting')->layout('layouts.setting');
    }
}
