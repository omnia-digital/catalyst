<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ToggleAllLivestreamEpisodesPublishedStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change-all-episodes-published {--status=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change all the Livestream Episodes Published Status ON/OFF';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $status = $this->option('status');

        if (empty($status)) {
            $this->error('A Status is required. You can enter it as --status=true');
            return;
        }

        if($this->confirm("Are you sure you want to change all Livestream Episodes Published Statuses to ($status)?")) {
            if ($status === 'true') {
                DB::connection('default')->table('livestream_episodes')->update(['is_published' => 1]);
            } else {
                DB::connection('default')->table('livestream_episodes')->update(['is_published' => 0]);
            }
            $this->info("Livestream Episodes Published Statuses have been changed to ($status)");
        }


    }
}
