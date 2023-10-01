<?php

namespace Modules\Livestream\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Livestream\Episode;
use Modules\Livestream\Services\MuxService;
use MuxPhp\ApiException;

class UpdateEpisodeDurationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'episode:update-duration {livestream_account_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update livestream episode duration if missing.';

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
     *
     * @throws ApiException
     */
    public function handle()
    {
        $liveStreamAccountId = $this->argument('livestream_account_id');

        $episodes = Episode::query()
            // Only filter by livestream account id if passing it as an argument,
            ->when($liveStreamAccountId, function ($query) use ($liveStreamAccountId) {
                $query->where('livestream_account_id', $liveStreamAccountId);
            })
            ->where(function ($query) {
                $query->whereNotNull('mux_asset_id')->orWhere('mux_asset_id', '!=', '');
            })
            ->where(function ($query) {
                $query->whereNull('duration')->orWhere('duration', '');
            })->get();

        $mux = (new MuxService)->getAssetApi();

        $episodes->each(function ($episode) use ($mux) {
            try {
                $duration = $mux->getAsset($episode->mux_asset_id)['data']['duration'];
                $durationInMillisecond = $duration * 1000;

                $episode->update(['duration' => $durationInMillisecond]);
            } catch (Exception $e) {
                Log::error($e);
            }
        });
    }
}
