<?php

namespace Modules\Livestream\Http\Livewire\Stream;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Models\Stream;
use Modules\Livestream\Services\Mux\MuxLivestream;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;
use Modules\Livestream\Support\Livewire\WithNotification;

/**
 * @property LivestreamAccount $livestreamAccount
 */
class Streams extends Component
{
    use WithLivestreamAccount, WithNotification, AuthorizesRequests;

    public bool $resetStreamKeyModelOpen = false;

    public ?string $streamId = null;

    public function openResetStreamKeyModal(string $streamId)
    {
        $this->streamId = $streamId;
        $this->resetStreamKeyModelOpen = true;
    }

    public function resetStreamKey()
    {
        $stream = Stream::where('stream_id', $this->streamId)->first();

        if (!$stream) {
            $this->error('Cannot find the Stream ID: ' . $this->streamId);

            return;
        }

        $this->authorize('update', $stream);

        $newStreamKey = app(MuxLivestream::class)->instance()->resetStreamKey($this->streamId);

        if (!isset($newStreamKey['data']['stream_key'])) {
            $this->error('Cannot get the new stream key.');

            return;
        }

        $stream->update(['stream_key' => $newStreamKey['data']['stream_key']]);

        $this->reset('streamId', 'resetStreamKeyModelOpen');
        $this->success('Reset stream key successfully!');
    }

    public function render()
    {
        $streams = $this->livestreamAccount->streams()
            ->latest()
            ->get();

        return view('stream.streams', [
            'streams' => $streams,
        ]);
    }
}
