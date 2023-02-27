<?php namespace App\Listeners;

use App\Enums\StreamStatus;
use App\Events\VideoAssetReady;
use App\Models\Episode;
use App\Models\Stream;
use App\Services\Mux\Concerns\HasThumbnail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaveMuxAsset implements ShouldQueue
{
    use InteractsWithQueue, HasThumbnail;

    public function handle(VideoAssetReady $event)
    {
        $uploadId = Arr::get($event->data, 'data.passthrough');

        // Since the upload video and livestream are the same payload,
        // so we just need to check for the upload ID to determine which one it is.
        $uploadId
            ? $this->handleUploadedVideo($uploadId, $event->data)
            : $this->handleLivestream($event->data);
    }

    /**
     * @param string $uploadId
     * @param array $payload
     */
    private function handleUploadedVideo(string $uploadId, array $payload): void
    {
        if (!($episode = Episode::findByUploadId($uploadId))) {
            Log::error('Cannot find uploaded episode with ID: ' . $uploadId);

            return;
        }

        $playbackIds = Arr::get($payload, 'data.playback_ids');
        $durationInSecond = Arr::get($payload, 'data.duration');
        $trackType = Arr::get($payload, 'data.tracks.0.type');

        // Update the thumbnail & duration for episode.
        $episode->update([
            'thumbnail' => $trackType === 'audio' ? null : $this->getMuxThumbnail($playbackIds[0]['id']),
            'duration'  => $durationInSecond ? $durationInSecond * 1000 : null
        ]);

        $trackType === 'audio'
            ? $episode->createMuxAudio(Arr::get($payload, 'object.id'), $playbackIds)
            : $episode->createMuxVideo(Arr::get($payload, 'object.id'), $playbackIds);
    }

    /**
     * @param array $payload
     * @throws \MuxPhp\ApiException
     */
    private function handleLivestream(array $payload): void
    {
        $streamId = $payload['data']['live_stream_id'];

        // Find stream based on stream id
        $stream = Stream::where('stream_id', $streamId)->first();

        if (empty($stream)) {
            throw new \Exception('Could not find Stream');
        }

        $livestreamAccount = $stream->livestreamAccount;

        // Enable stream if the billable is subscribed and the stream is disabled.
        if ($livestreamAccount->team->subscribed() && $stream->isDisabled()) {
            $stream->enable();
        }

        //$plan = $stream->livestreamAccount->team->sparkPlan();

        //@TODO: Allow a church to stream for x amount of minutes per week (https://app.productive.io/9424-omnia/task/1789452)
        //if (!$plan || $plan->id === 'livestream-free') {
        //    app(MuxLivestream::class)->finishLivestreamRequest($streamId);
        //
        //    return;
        //}

        // @todo - need to make sure we don't have an episode already so we don't create duplicates.

        DB::transaction(function () use ($livestreamAccount, $stream, $payload) {
            $episodeTemplate = $livestreamAccount->defaultEpisodeTemplate();

            $episode = Episode::createFromTemplate([
                'title'                 => $episodeTemplate?->template['title'] ?? 'Untitled',
                'description'           => $episodeTemplate?->template['description'] ?? null,
                'date_recorded'         => now(config('app.timezone')),
                'livestream_account_id' => $livestreamAccount->id,
                'is_live_now'           => true,
                'thumbnail'             => $episodeTemplate['default_thumbnail'] ?? null
            ]);

            // Create Video & Playback Ids from Mux data for this Episode
            $episode->createMuxVideo(
                Arr::get($payload, 'object.id'),
                Arr::get($payload, 'data.playback_ids')
            );

            // Set active episode on stream.
            $stream->update([
                'status'            => StreamStatus::ACTIVE,
                'active_episode_id' => $episode->id
            ]);
        });
    }
}
