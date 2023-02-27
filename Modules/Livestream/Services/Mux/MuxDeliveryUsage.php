<?php namespace App\Services\Mux;

use App\Models\LivestreamAccount;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use MuxPhp\Api\DeliveryUsageApi;
use MuxPhp\Configuration;
use MuxPhp\Models\DeliveryReport;

class MuxDeliveryUsage
{
    protected DeliveryUsageApi $deliveryUsageApi;

    public function __construct(Client $client, Configuration $configuration)
    {
        $this->deliveryUsageApi = new DeliveryUsageApi($client, $configuration);
    }

    /**
     * Get all delivery usage data.
     *
     * @param array $timeframe See the options format at https://docs.mux.com/reference#delivery-usage
     * @return Collection
     * @throws \MuxPhp\ApiException
     */
    public function getDeliveryUsage(array $timeframe = []): Collection
    {
        $page = 1;
        $result = collect();

        do {
            $deliveryUsage = $this->deliveryUsageApi->listDeliveryUsage(
                page: $page,
                timeframe: $timeframe
            );

            $result = $result->merge(
                collect($deliveryUsage['data'])->map(fn(DeliveryReport $deliveryReport) => (array)$deliveryReport->jsonSerialize())
            );

            $page = $page + 1;
        } while (!empty($deliveryUsage['data']));

        return $result;
    }

    /**
     * @return Collection
     * @throws \MuxPhp\ApiException
     */
    public function getDeliveryUsageForStats(): Collection
    {
        return $this->getDeliveryUsage([
            Carbon::now()->subDays(90)->timestamp, // Get data in 90 days.
            time()
        ]);
    }

    /**
     * @param LivestreamAccount $livestreamAccount
     * @param array $timeframe See the options format at https://docs.mux.com/reference#delivery-usage
     * @return Collection
     * @throws \MuxPhp\ApiException
     */
    public function getDeliveryUsageByAccount(LivestreamAccount $livestreamAccount, array $timeframe = []): Collection
    {
        // Get all the live stream ids of the given account.
        $streamIds = $livestreamAccount->streams()->pluck('stream_id');

        // All the usages from Mux.
        $allUsages = $this->getDeliveryUsage($timeframe);

        // Get all the usages belong to the given account via it's live stream ids.
        $hasStreamIdUsages = $allUsages->whereIn('live_stream_id', $streamIds);

        // Get all the usages that does not have the live_stream_id.
        $hasNoStreamIdUsages = $allUsages->whereNotIn('live_stream_id', $streamIds)->whereNull('live_stream_id');

        // We are going to find out which delivery usages belongs to the given account by using mux_asset_id.
        // First, we grab all the mux asset ids of the given account,
        // then look up in the $hasNoStreamIdUsages variable.
        $assetIds = $livestreamAccount->episodes()->pluck('mux_asset_id');
        $hasNoStreamIdUsages = $hasNoStreamIdUsages->whereIn('asset_id', $assetIds);

        // Finally, merge $hasNoStreamIdUsages and $hasStreamIdUsages
        // to get all the delivery usages of the given account.
        return $hasNoStreamIdUsages->merge($hasStreamIdUsages);
    }

    /**
     * @param LivestreamAccount $livestreamAccount
     * @return Collection
     * @throws \MuxPhp\ApiException
     */
    public function getDeliveryUsageForInvoice(LivestreamAccount $livestreamAccount): Collection
    {
        return $this->getDeliveryUsageByAccount($livestreamAccount, [
            Carbon::now()->subDays(30)->timestamp, // Get data in 30 days.
            Carbon::now()->subHours(13)->timestamp
        ]);
    }
}
