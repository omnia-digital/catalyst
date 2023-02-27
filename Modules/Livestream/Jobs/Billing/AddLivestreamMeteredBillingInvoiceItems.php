<?php

namespace App\Jobs\Billing;

use Illuminate\Support\Facades\Log;
use App\Episode;
use App\Events\Episode\EpisodeVideosFinishedSyncing;
use App\Events\Episode\EpisodeVideosStartedSyncing;
use App\Events\Video\FinishedMovingLiveVideosToTmp;
use App\Events\Video\LiveVideosProcessing;
use App\Events\Video\LiveVideosStartedProcessing;
use App\Jobs\LivestreamJob;
use App\Services\BillingService;
use App\Services\EpisodeService;

/**
 * Class AddLivestreamMeteredBillingInvoiceItems
 * @package App\Jobs\Billing
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
        BillingService::addMeteredBillingInvoiceItems($this->_team,$this->_invoiceId,$this->_subscriptionId);
        Log::info(__CLASS__ . 'ENDED');
    }
}
