<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Omnia;
use App\Services\SubscriptionService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Class BanUser
 *
 * @package App\Console\Commands
 */
class BanUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ban:user {id} {--revert}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ban a user using the given id';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('[START] - ' . __CLASS__);

        try {
            $id = $this->argument('id');
            $revert = $this->option('revert');
            // get all of the teams
            $user = User::find($id);

            if ($revert) {
                if($this->confirm("Are you sure you want to revert the ban on this User ($id)?")) {
                    if ($user->isNotBanned()) {
                        $this->info('That User is not banned');
                    } else {
                        $user->unban();
                        $this->info("Successfully UnBanned User ($id)");
                    }
                } else {
                    $this->info('Cancelled Ban Revert');
                }
            } else if ($this->confirm("Are you sure you want to ban this User ($id)?")) {
                if ($user->isBanned()) {
                    $this->info('That User is already banned');
                } else {
                    $user->ban();
                    $this->info("Successfully Banned User ($id)");
                }
            } else {
                $this->info('Cancelled Ban');
            }
        } catch (Exception $e) {
            $this->info($e->getMessage());
            Log::error($e->getMessage());
        }

        Log::info('[FINISHED] - ' . __CLASS__);

    }
}
