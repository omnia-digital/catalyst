<?php

namespace Modules\Livestream\Jobs\Billing;

use Illuminate\Support\Facades\Log;
use Modules\Livestream\Episode;
use Modules\Livestream\Jobs\LivestreamJob;
use Modules\Livestream\Services\BillingService;

/**
 * Class AddLivestreamMeteredBillingInvoiceItems
 */
class AddLivestreamMeteredBillingInvoiceItems extends LivestreamJob
{
    private $_team;
    private $_invoiceId;
    private $_subscriptionId;

    /**
     * Create a new job instance.
     *
     * @param Episode $episode
     */
    public function __construct($team, $invoiceId, $subscriptionId)
    {
        $this->_team = $team;
        $this->_invoiceId = $invoiceId;
        $this->_subscriptionId = $subscriptionId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(__CLASS__ . 'STARTED');
        BillingService::addMeteredBillingInvoiceItems($this->_team, $this->_invoiceId, $this->_subscriptionId);
        Log::info(__CLASS__ . 'ENDED');
    }
}
