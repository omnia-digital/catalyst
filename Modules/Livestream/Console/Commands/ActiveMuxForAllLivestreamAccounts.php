<?php

namespace App\Console\Commands;

use App\Omnia;
use Illuminate\Console\Command;
use App\LivestreamAccount;
use App\Repositories\StreamRepository;

class ActiveMuxForAllLivestreamAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'active-mux-all-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate Mux Integration for all Livestream Accounts (that are not already active)';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if($this->confirm("Are you sure you want to activate Mux on all Livestream Accounts (that aren't already actived)?")) {
            $livestream_accounts = LivestreamAccount::all();
            foreach ($livestream_accounts as $livestream_account) {

                // If Mux is already active, skip this $livestream_account
                if ($livestream_account->mux_livestream_active === true) {
                    continue;
                }

                $defaultStream = $livestream_account->default_stream;
                if (empty($defaultStream)) {
                    try {
                        $stream = Omnia::interact(StreamRepository::class . '@create', [$livestream_account]);
                        sleep(1);
                        if (empty($stream)) {
                            throw new \Exception("Could not find new Stream after creating");
                        }
                    } catch(\Exception $e) {
                        $this->error("Error when creating a Stream for LivestreamAccount: " . $livestream_account->id . " | Error: " . $e->getMessage());
                    }
                }
                $livestream_account->mux_livestream_active = true;
                $livestream_account->mux_vod_active = true;
                $livestream_account->mux_stream_targets_active = true;
                $livestream_account->save();
            }
        } else {
            $this->info("Cancelled");
        }


    }
}
