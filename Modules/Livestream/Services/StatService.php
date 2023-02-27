<?php
namespace Modules\Livestream\Services;

use Modules\Livestream\Stat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use KeenIO\Client\KeenIOClient;
use Modules\Livestream\Services\LivestreamService;
use Wensleydale\KeenLaravel\KeenFacade;

class StatService extends LivestreamService
{
	protected $_analytics_service = null;

	public function __construct($client = null)
	{
		Log::info( 'Starting Analytics Service' );

		if (is_null($client)) {
            $client = KeenIOClient::factory([
                'projectId' => env('KEEN_PROJECT_ID'),
                'writeKey' => env('KEEN_WRITE_KEY'),
                'readKey' => env('KEEN_READ_KEY')
            ]);
		}
		$this->_analytics_service = $client;
	}

	/**
	 * Runs and extraction request on the analytics service
	 *
	 * @param string $eventCollection
	 * @param Collection $parameters
	 *
	 * @return
	 */
	protected function _extraction($eventCollection, Collection $parameters)
	{
		return $this->_analytics_service->extraction($eventCollection,$parameters->all());
	}

    /**
     * @param $eventCollection
     * @param Collection $parameters
     * @return mixed
     */
    protected function _sum($eventCollection, Collection $parameters)
    {
        return $this->_analytics_service->sum($eventCollection,$parameters->all());
    }

}
