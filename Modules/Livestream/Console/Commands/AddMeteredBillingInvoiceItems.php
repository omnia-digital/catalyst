<?php

namespace Modules\Livestream\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Class AddMeteredBillingInvoiceItems
 * Add metered billing items for current month from each module
 *
 * @package App\Console\Commands
 */
class AddMeteredBillingInvoiceItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-metered-billing-invoice-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('[START] - ' . __CLASS__);

        try {
            // get all of the teams

            // foreach team
                // run through each modules metered billing
                // check if has paid livestream plan
                    // get storage rate
                    // get current storage total
                    // get total cost this month
                    // add total as invoice item to this team's next invoice


            // at the end of the month
                // check if the team has a livestream plan
                    // if they do
                        // check if they have a metered billing plan
                            // if they don't have a metered billing plan
                                // subscribe them to livestream-metered
                                    // use the current date as the date for the recurring billing plan
                            // if they do, then continue on
                    // if they don't, continue on
                // check other module plans



            // when a livestream-metered invoice is created

            // if team cancels their plan, make sure to charge them on there last day for the storage they are using
                // notify them that we will delete all of their storage until they have only 5GB remaining,
                    // and then they can keep that, but we will delete each old episode after that

        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        Log::info('[FINISHED] - ' . __CLASS__);

    }
}
