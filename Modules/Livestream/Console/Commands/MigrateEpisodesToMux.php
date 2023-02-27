<?php

    namespace Modules\Livestream\Console\Commands;

    use Modules\Livestream\Omnia;
    use Carbon\Carbon;
    use Exception;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\Storage;
    use Modules\Livestream\Episode;
    use Modules\Livestream\LivestreamAccount;
    use Modules\Livestream\PlaybackId;
    use Modules\Livestream\Repositories\VideoRepository;
    use Modules\Livestream\Services\EpisodeService;
    use Modules\Livestream\Services\MuxService;
    use Modules\Livestream\Video;
    use Modules\Livestream\VideoSourceType;

    class MigrateEpisodesToMux extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'migrate-episodes-to-mux {--livestreamAccount=} {--episode=} {--video=}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Migrate Episodes to Mux from Wowza/S3';

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle()
        {
            if ($this->confirm("Are you sure you want to migrate all Episodes to Mux from S3?")) {

                $episodeId = $this->option('episode');
                if (!empty($episode)) {
                    $episode = Episode::findOrFail($episodeId);
                }

                $videoId = $this->option('video');
                if ( empty($episode) && ! empty($videoId)) {
                    $video   = Video::findOrFail($videoId);
                    $episode = $video->episode;
                }

                if (!empty($episode)) {
                    $this->migrateEpisode($episode);
                    return;
                }

                // Get Episodes from Livestream Account or use all Episodes
                $livestreamAccount = $this->option('livestreamAccount');
                if ( ! empty($livestreamAccount)) {
                    $livestreamAccount = LivestreamAccount::findOrFail($livestreamAccount);
                    $episodes          = $livestreamAccount->episodes;
                } else {
//                    $episodes = Episode::all();
                }

                if (!empty($episodes)) {
                    foreach ($episodes as $episode) {
                        $this->migrateEpisode($episode);
                    }
                } else {
                    $this->error('Could not find Episodes, Video, or LivestreamAccount');
                }
            } else {
                $this->info("Cancelled");
            }
        }

        /**
         * Migrate Episode to Mux
         *
         * @param $episode
         */
        public function migrateEpisode($episode)
        {
            $this->info("Episode: $episode->id");
            // check if the episodes videos are on mux already
            if ( ! empty($episode->mux_asset_id)) {
                // if so, return
                return;
            }
            $this->info("Moving...");

            $livestreamAccount = $episode->livestreamAccount;
            $this->info("LivestreamAccount: $livestreamAccount->id");
            $videos = $episode->videos;
            if ($videos->count() > 1) {
                $this->info("More than 1 video for Episode: $episode->id on LivestreamAccount: $livestreamAccount->id");
            }
            // get each video for episode
            foreach ($videos as $video) {

                $this->info("Video: $video->id");

                // check if video source type is mux
                if (!empty($video->videoSourceType) && $video->videoSourceType->slug === 'mux') {
                    // if it is skip to the next one
                    continue;
                }
                $url = $video->download_url;

                $this->info("Url: $url");
                if (empty($url) || ! strpos($url, '.mp4')) {
                    $this->error("Url is not working...");
                    continue;
                }

                // @TODO [Josh] - check if the link is available (if not, it's probably Glacier Storage)

                // create asset on mux
                $data = [
                    'input'       => [
                        'url' => (string)$url,
                    ],
                    "playback_policy" => "public",
                    'mp4_support' => 'standard'
                ];


                try {

                    $muxService = new MuxService();
                    $muxAsset   = $muxService->createAsset($data);

                    if ( ! empty($muxAsset)) {
                        // save Mux asset id to episode
                        $episode->mux_asset_id = $muxAsset->getId();
                        $episode->save();

                        // Create PlaybackIds based on Mux PlaybackIds for this asset/episode
                        $muxPlaybackIds = $muxAsset->getPlaybackIds();
                        foreach ($muxPlaybackIds as $mux_playback_id) {
                            $episodePlaybackId = PlaybackId::create([
                                'playback_id'       => $mux_playback_id->getId(),
                                'policy'            => $mux_playback_id->getPolicy(),
                                'playbackable_type' => Episode::class,
                                'playbackable_id'   => $episode->id,
                            ]);
                        }

                        // get Mux Video Source Type
                        $muxVideoSourceType = VideoSourceType::where('slug', '=', 'mux')->first();

                        if (empty($muxVideoSourceType)) {
                            throw new Exception("Could not find Mux Video Source Type");
                        }

                        // create video
                        $video->update([
                            'full_file_path'       => null,
                            'video_source_type_id' => $muxVideoSourceType->id,
                        ]);

                        $this->info("Video Updated: $video->id");

                        // this ensures we don't max out calls-per-second on the APIs
                        sleep(1);

                    }
                } catch (\Exception $e) {
                    $this->error("Error: Episode: $episode->id on LivestreamAccount: $livestreamAccount->id : " . $e->getMessage());
                }

            }
        }

        /**
         * Get Signed URL on S3
         *
         * @param $video
         *
         * @return mixed
         */
        public function getSignedUrl($video)
        {
            $this->info("Creating Link to existing Video on S3...");

            // get download url
            $s3               = Storage::disk('s3-vod');
            $bucket           = Config::get('filesystems.disks.s3-vod.bucket');
            $fileDownloadName = $video->episode->livestreamAccount->account_slug . '_' . $video->episode->id . '_' . $video->id . '_' . Carbon::now()->timestamp . '.' . $video->file_type;
            $client           = $s3->getDriver()->getAdapter()->getClient();
            $expiry           = "+240 minutes";
            $command          = $client->getCommand('GetObject', [
                'Bucket'                     => $bucket,
                'Key'                        => $video->full_file_path,
                'ResponseContentDisposition' => 'attachment; filename="' . $fileDownloadName . '"',
            ]);

            $request = $client->createPresignedRequest($command, $expiry);

            $url = $request->getUri();

            return $url;
        }
    }
