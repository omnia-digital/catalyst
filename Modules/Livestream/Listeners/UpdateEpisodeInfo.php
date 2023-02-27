<?php namespace App\Listeners;

use App\Events\StreamCompleted;
use App\Models\Video;
use App\Services\Mux\Concerns\HasThumbnail;
use Illuminate\Support\Arr;

class UpdateEpisodeInfo
{
    use HasThumbnail;

    public function handle(StreamCompleted $event)
    {
        $video = Video::where('video_source_id', $event->data['object']['id'])->first();

        if (!$video) {
            throw new \Exception('Could not find video with Mux Asset ID: ' . $event->data['object']['id']);
        }

        $update = [
            'duration'  => Arr::get($event->data, 'data.duration') * 1000
        ];

        if (empty($video->episode->thumbnail)) {
            $update['thumbnail'] = $this->getMuxThumbnail(Arr::get($event->data, 'data.playback_ids.0.id'));
        }

        $video->episode->update($update);
    }
}
