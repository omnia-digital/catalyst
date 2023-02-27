<?php namespace App\Registries\VideoSource;

use App\Models\Video;
use App\Registries\VideoSource\Concerns\BaseVideoSource;
use App\Services\Mux\Concerns\Downloadable;
use App\Services\Mux\MuxAsset;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class S3VideoSource implements BaseVideoSource
{
    public function name(): string
    {
        return 'S3';
    }

    public function asSourceVideo()
    {
        // TODO: Implement asSourceVideo() method.
    }

    public function playbackUrl(Video $video): ?string
    {
        return config('livestream.vod_playback_url')
            . $video->episode->livestreamAccount->id . '/'
            . $video->episode_id . '/'
            . $video->file_name . '.'
            . $video->file_type;
    }

    public function downloadUrl(Video $video): ?string
    {
        $client = Storage::disk('s3-vod')->getDriver()->getAdapter()->getClient();

        $command = $client->getCommand('GetObject', [
            'Bucket'                     => config('filesystems.disks.s3-vod.bucket'),
            'Key'                        => $video->full_file_path,
            'ResponseContentDisposition' => 'attachment; filename="' . $this->downloadFilename($video) . '"',
        ]);

        return $client->createPresignedRequest($command, '+240 minutes')->getUri();
    }

    public function delete(Video $video): void
    {
        // TODO: Implement delete() method.
    }

    public function isProcessing(Video $video): bool
    {
        // TODO: Implement isProcessing() method.
    }

    /**
     * @param Video $video
     * @return string
     */
    private function downloadFilename(Video $video): string
    {
        return $video->episode->livestreamAccount->account_slug
            . '_' . $video->episode->id . '_'
            . $video->id . '_'
            . Carbon::now()->timestamp . '.'
            . $video->file_type;
    }
}
