<?php namespace Modules\Livestream\Actions\Livestream;

use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Models\Stream;
use Modules\Livestream\Models\Team;
use Modules\Livestream\Services\Mux\MuxLivestream;
use Modules\Livestream\Support\Livestream\WithLivestreamAccount;

class CreateMuxStreamAction
{
    use WithLivestreamAccount;

    /**
     * Create mux stream of a team.
     *
     * @param Team|null $team
     * @return Stream
     * @throws \MuxPhp\ApiException
     */
    public function execute(?Team $team = null): Stream
    {
        $muxStreamData = app(MuxLivestream::class)->createLivestreamRequest();

        // Create stream.
        $stream = $this->livestreamAccount($team)->streams()->create([
            'stream_id'        => $muxStreamData->getId(),
            'stream_key'       => $muxStreamData->getStreamKey(),
            'status'           => $muxStreamData->getStatus(),
            'reconnect_window' => $muxStreamData->getReconnectWindow(),
        ]);

        // Create playback ids.
        $playbackIds = [];

        foreach ($muxStreamData->getPlaybackIds() as $muxPlaybackId) {
            $playbackIds[] = [
                'playback_id' => $muxPlaybackId->getId(),
                'policy'      => $muxPlaybackId->getPolicy(),
            ];
        }

        $stream->playbackIds()->createMany($playbackIds);

        return $stream;
    }

    private function livestreamAccount(?Team $team = null): LivestreamAccount
    {
        return is_null($team) ? $this->getLivestreamAccountProperty() : $team->livestreamAccount;
    }
}
