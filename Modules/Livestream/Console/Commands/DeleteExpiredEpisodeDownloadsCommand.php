<?php

namespace Modules\Livestream\Console\Commands;

use Modules\Livestream\Enums\EpisodeDownloadStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Modules\Livestream\EpisodeDownload;

class DeleteExpiredEpisodeDownloadsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'episode-download:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all expired episode downloads.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \MuxPhp\ApiException
     */
    public function handle()
    {
        $expiredEpisodeDownloads = EpisodeDownload::expired()->get();

        $expiredEpisodeDownloads->each(function (EpisodeDownload $episodeDownload) {
            $folderPath = Storage::disk('episode-download')->getAdapter()->getPathPrefix() . $episodeDownload->code;

            if (file_exists($folderPath)) {
                array_map('unlink', glob("$folderPath/*.*"));
                rmdir($folderPath);

                $episodeDownload->update(['status' => EpisodeDownloadStatus::EXPIRED]);
            }
        });
    }
}
