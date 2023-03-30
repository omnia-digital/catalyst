<?php

namespace Modules\Livestream\Console\Commands;

    use Exception;
    use Illuminate\Console\Command;
    use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\LivestreamAccount;

    class ActivateMP4DownloadForAllEpisodes extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'activate-mux-mp4 {--livestreamAccount=} {--episode=}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Activate Mux MP4 support for all Episodes';

        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle()
        {
            if ($this->confirm('Are you sure you want to activate Mux MP4 support on all mux Episodes?')) {
                $livestreamAccountId = $this->option('livestreamAccount');
                $episodeId = $this->option('episode');

                if (! empty($episodeId)) {
                    $episode = Episode::findOrFail($episodeId);
                }

                if (! empty($episode)) {
                    $this->activeMp4Episode($episode);
                    $this->info('Finished Updating!');

                    return;
                } elseif (! empty($livestreamAccountId)) {
                    $livestreamAccount = LivestreamAccount::findOrFail($livestreamAccountId);
                    $episodes = $livestreamAccount->episodes()->where('mux_asset_id', '<>', '')->get();
                } else {
                    $episodes = Episode::where('mux_asset_id', '<>', '')->get();
                }

                $this->info('Updating ' . $episodes->count() . ' Episodes');
                foreach ($episodes as $episode) {
                    $this->activeMp4Episode($episode);
                }

                $this->info('Finished Updating!');
            } else {
                $this->info('Cancelled');
            }
        }

        /**
         * @return mixed
         */
        public function activeMp4Episode($episode)
        {
            try {
                $muxService = new MuxService;
                $this->info('Update Episode: ' . $episode->id);
                $asset_id = $episode->mux_asset_id;
                $responseData = $muxService->addAssetMP4Support($asset_id);
                if ($responseData === false) {
                    $this->info('Not needed. MP4 Support already Standard');
                }
                sleep(1); // sleep ensures we don't max out API calls per second
            } catch (Exception $e) {
                $this->error('Error with Episode: ' . $episode->id . ': ' . $e->getMessage());
            }

            return $episode;
        }
    }
