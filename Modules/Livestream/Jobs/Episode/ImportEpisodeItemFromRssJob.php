<?php

namespace Modules\Livestream\Jobs\Episode;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Livestream\Actions\Episodes\CreateNewEpisode;
use Modules\Livestream\Models\Category;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Services\Mux\MuxAsset;

class ImportEpisodeItemFromRssJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    public function __construct(
        private array $episodeData,
        private LivestreamAccount $livestreamAccount,
        private ?Episode $episode
    ) {
    }

    public function handle()
    {
        // Do not overwhelm Mux api
        sleep(1);

        DB::transaction(function () {
            // If episode exists, don't create anymore, just upload the video for that episode.
            // Otherwise, create new episode and then upload video.
            if (! $this->episode) {
                $this->episode = (new CreateNewEpisode)->execute(
                    collect($this->episodeData)->only(['title', 'date_recorded', 'description', 'main_passage', 'main_speaker_id'])->all(),
                    $this->livestreamAccount
                );
            }

            // Only upload file to Mux when the item has media URL
            if ($this->episodeData['media_url']) {
                $this->episode->update(['upload_id' => $uploadId = Str::random()]);

                app(MuxAsset::class)->createFromUrl(
                    $this->episodeData['media_url'],
                    ['passthrough' => $uploadId]
                );
            }

            $this->saveCategory();
            $this->saveSeries();
            $this->saveAttachments();
        });
    }

    private function saveAttachments(): void
    {
        // Do not duplicate attachments.
        if ($this->episode->media()->exists()) {
            return;
        }

        foreach ($this->episodeData['attachments'] ?? [] as $url) {
            $this->episode->addMediaFromUrl($url)->toMediaCollection();
        }
    }

    private function saveSeries(): void
    {
        $series = $this->livestreamAccount->series()->firstOrCreate(
            ['name' => $this->episodeData['series']]
        );

        $this->episode->series()->sync($series->id);
    }

    private function saveCategory(): void
    {
        if ($this->episodeData['category']) {
            $category = Category::firstOrCreate(['name' => $this->episodeData['category']]);

            $this->episode->update(['category_id' => $category->id]);
        }
    }
}
