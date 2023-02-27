<?php namespace Modules\Livestream\Jobs\Episode;

use Modules\Livestream\Enums\EpisodeDownloadStatus;
use Modules\Livestream\Notifications\EpisodeDownloadWasFailedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Modules\Livestream\Episode;
use Modules\Livestream\EpisodeDownload;
use Modules\Livestream\Events\EpisodeDownload\EpisodeDownloadIsReady;
use Throwable;
use ZipArchive;

class DownloadEpisodes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var EpisodeDownload
     */
    private $episodeDownload;

    /**
     * @var int
     */
    private $livestreamAccountId;

    /**
     * Create a new job instance.
     *
     * @param EpisodeDownload $episodeDownload
     * @param int $livestreamAccountId
     */
    public function __construct(EpisodeDownload $episodeDownload, int $livestreamAccountId)
    {
        $this->livestreamAccountId = $livestreamAccountId;
        $this->episodeDownload = $episodeDownload;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \MuxPhp\ApiException
     * @throws \Exception
     */
    public function handle()
    {
        $episodes = Episode::query()
            ->where('livestream_account_id', $this->livestreamAccountId)
            ->get();

        $this->downloadEpisodes($episodes);

        $downloadPath = $this->zipEpisodes();

        $this->episodeDownload->update([
            'status'        => EpisodeDownloadStatus::READY,
            'download_path' => $downloadPath
        ]);

        event(new EpisodeDownloadIsReady($this->episodeDownload));
    }

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        $this->episodeDownload->update([
            'status'        => EpisodeDownloadStatus::FAILED,
            'failed_reason' => $exception->getMessage()
        ]);

        $this->episodeDownload->user->notify(new EpisodeDownloadWasFailedNotification($this->episodeDownload));
    }

    /**
     * Download all episodes from Mux.
     *
     * @param $episodes
     * @throws \MuxPhp\ApiException
     */
    private function downloadEpisodes($episodes)
    {
        $this->episodeDownload->update(['status' => EpisodeDownloadStatus::DOWNLOADING]);

        $episodes->each(function (Episode $episode) {
            $asset = $episode->asMuxAsset();

            // Do nothing if asset is not found or this asset does not supports mp4.
            if (!$asset || !$asset->isDownloadable()) {
                return;
            }

            if (!($playbackId = $asset->defaultPlaybackId())) {
                return null;
            }

            Storage::disk('episode-download')->put(
                $this->episodeDownload->code . '/' . $episode->title . '.mp4',
                file_get_contents($asset->downloadLink())
            );
        });
    }

    /**
     * Zip all episodes in folder.
     *
     * @return string;
     * @throws \Exception
     */
    private function zipEpisodes()
    {
        $this->episodeDownload->update(['status' => EpisodeDownloadStatus::ZIPPING]);

        $filename = time() . '.zip';
        $rootFolderPath = Storage::disk('episode-download')->getAdapter()->getPathPrefix();
        $folderPath = $rootFolderPath . '/' . $this->episodeDownload->code;
        $files = glob($folderPath . '/*');

        if (!count($files)) {
            throw new \Exception('Cannot find any files to zip');
        }

        $zip = new ZipArchive;
        $zip->open($folderPath . '/' . $filename, ZipArchive::CREATE);

        foreach ($files as $file) {
            $zip->addFile($file);
        }

        $zip->close();

        return basename($rootFolderPath) . '/' . $this->episodeDownload->code . '/' . $filename;
    }
}
