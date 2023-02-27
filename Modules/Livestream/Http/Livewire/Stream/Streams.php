<?php

namespace App\Http\Livewire\Stream;

use App\Models\LivestreamAccount;
use App\Models\Stream;
use App\Services\Mux\MuxLivestream;
use App\Support\Livestream\WithLivestreamAccount;
use App\Support\Livewire\WithNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

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
            'streams' => $streams
        ]);
    }
}
