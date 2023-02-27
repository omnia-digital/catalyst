<?php

namespace App\Services;

use App\Services\Service;
use GuzzleHttp\Client;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Exceptions\TransVideoException;
use App\LivestreamAccount;
use Auth;
use App\Repositories\EpisodeTemplateRepository;
use App\StreamIntegration;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StreamTargetService extends Service
{
	const WOWZA_URL = 'http://livestream.omnia-app.org:8087/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/live/pushpublish/mapentries';
    private $_livestreamAccount;
    private $_team;
    private $_streamName;
	private $_streamTargetType;
	private $_httpClient;
	private $_streamIntegrationService;

	/**
	 * StreamService constructor.
	 *
	 * @param LivestreamAccount $LivestreamAccount
	 * @param $streamName
	 * @param string $streamTargetType
	 */
    public function __construct(LivestreamAccount $LivestreamAccount, $streamName = null, $streamTargetType = 'facebook')
    {
        $this->_livestreamAccount = $LivestreamAccount;
        $this->_team = $LivestreamAccount->team;
	    if (!empty($streamName)) {
	        $this->_streamName = $this->_livestreamAccount->id . '/' . config('livestream.livestream_episode_auto_record_stream_name');
	    } else {
	        $this->_streamName = $streamName;
	    }
	    $this->_streamTargetType = $streamTargetType;
	    $this->_streamIntegrationService = new StreamIntegrationService($LivestreamAccount);

	    $config = [
	    	'headers' => [
		        'Accept' => 'application/json',
			    'Content-Type' => 'application/json'
	        ]
	    ];
	    $this->_httpClient = new Client([$config]);
    }

	/**
	 * Check what stream targets this team should have
	 * Then, create/update/delete them
	 */
	public function checkStreamTargets()
	{
        Log::info('[START] - Started Checking Stream Targets');

        if (strpos($this->_streamName,'trans') !== false) {
            $message = 'Stream Target will not be created';
			Log::info('[Stream Target] - ' . $message);
			throw new TransVideoException($message);
		} else if (    $this->_team->onPlan('livestream-standard')
                    || $this->_team->onPlan('livestream-standard-yr')
                    || $this->_team->onPlan('livestream-premium')
                    || $this->_team->onPlan('livestream-premium-yr')
                    || $this->_team->onPlan('livestream-starter')
                    || $this->_team->onPlan('livestream-starter-yr')
                    || $this->_team->onPlan('livestream-growth')
                    || $this->_team->onPlan('livestream-growth-yr')
            ) { // @TODO [Josh] - should be like "if ($this->_team->can('stream-target-facebook'))"
			$stream_integrations = $this->_livestreamAccount->stream_integrations;
			if ($stream_integrations->isNotEmpty()) {
                Log::info('[Stream Integration] - Found Stream Integration(s)');
				$facebookStreamIntegrations = $stream_integrations->where('provider','facebook');
				if ($facebookStreamIntegrations->isNotEmpty()) {
                    Log::info('[Stream Integration] - Found a FB Live Stream Integration');
					$facebookStreamIntegration = $facebookStreamIntegrations->first();
                    if ($facebookStreamIntegration->enabled === true) {
                        Log::info('[FB Live] - Facebook Stream Integration Enabled');
                        $this->_streamIntegrationService->setStreamIntegration($facebookStreamIntegration);
						$this->enableFacebookStreamTargetForStream();
					} else {
                        Log::info('[FB Live] - Facebook Stream Integration Disabled');
                    }
				}
			} else {
                Log::info('[Stream Integration] - No Stream Integrations Found');
            }
		} else {
            Log::info('[Stream Target] - Not eligble for Stream Targets: Plan: ' . $this->_team->plan);
        }

        Log::info('[END] - Finished Checking Stream Targets');

    }

	/**
	 * API to delete, then create new Facebook Stream Target with new Facebook Live Video Stream Name
	 */
	public function enableFacebookStreamTargetForStream()
	{
		try {
			Log::info('[FB Live] - START');
			try {
				// Delete Stream Target
				$responseCode = $this->deleteStreamTarget();
                if ($responseCode >= 300 && $responseCode !== 404) { // ignoring 404
			        Log::error('[FB Live] - Failed to Delete Stream Target: Status Code: ' . $responseCode);
                } else {
			        Log::info('[FB Live] - Deleted Stream Target');
                }
			} catch(\Exception $e) {
				if ($e->getCode() !== 404) { // 404 means streamTarget doesn't exist, which we will ignore
			        Log::error('[FB Live] - Failed to Delete Stream Target: Status Code: ' . $e->getCode());
					throw $e;
				}
			}

			Log::info('[FB Live] - Get FB Stream Name');
            // Get Title and Description from Episode Template
            $episodeTemplateRepository = new EpisodeTemplateRepository($this->_livestreamAccount);
            $epsiodeTemplate = $episodeTemplateRepository->current();

            if ( ! empty($episodeTemplate)) {
                $params = [
                    'title'       => $epsiodeTemplate->title,
                    'description' => $epsiodeTemplate->description
                ];

                // Get a new FB Live Video Stream Name
                $target_stream_name = $this->_streamIntegrationService->getFacebookLiveVideoStreamName($params);

            } else {
                $target_stream_name = $this->_streamIntegrationService->getFacebookLiveVideoStreamName();
            }

			// @TODO [Josh] - need to come back and refactor this eventually to make it use adapters for different types of targets, such as facebook, google with properties such as host, streamName, etc. instead of using an array
			Log::info('[FB Live] - FB Stream Name: ' . $target_stream_name);
			$target_options = [
				'host'       => 'rtmp-api.facebook.com',
				'streamName' => $target_stream_name
			];

			// Create a new Stream Target
			Log::info('[FB Live] - Create Stream Target');

			$responseCode = $this->createStreamTarget( $target_options );
			$response = [
				'success' => 'true',
				'data'  => '',
                'code'  => $responseCode
			];
            if ($responseCode >= 300) {
                throw new \Exception('Error when trying to create Stream Target');
            }
			Log::info('[FB Live] - Response Code: ' . $responseCode);
			Log::info('[FB Live] - FINISHED - FB Live Stream Target Created Successfully');
			return response()->json($response);

		} catch(\Exception $e) {
			$response = [
				'success' => 'false',
				'error'  => $e->getMessage()
			];
			Log::error('[FB Live] - Failed with Errors: ' . $e->getMessage());
			return response()->json($response);
		}

    }

	/**
	 * @return string
	 */
	public function getStreamTargetList(  )
	{
		Log::info('[Stream Target INDEX] - Started');
		$response   = $this->_httpClient->get();
		Log::info('[Stream Target INDEX] - Finished');
		return $response->getReasonPhrase();
    }

	/**
	 * Create Stream Target on Wowza Server
	 *
	 * @param $target_options
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function createStreamTarget($target_options)
	{
		Log::info('[Stream Target CREATE] - Started');

		if ( $this->_streamTargetType === 'facebook' ) {
			$options['json'] = json_decode( '{
				"sourceStreamName":"' . $this->_streamName . '",
				"entryName":"' . $this->_streamTargetType .'-' . str_replace( '/', '-', $this->_streamName ) . '", 
				"profile":"rtmp", 
				"application":"rtmp", 
				"port":"443", 
				"destinationName":"rtmp",
				"sendSSL":"true",
				"host":"' . $target_options['host'] . '", 
				"streamName":"' . $target_options['streamName'] . '"
			}' );

			$response   = $this->_httpClient->post(self::WOWZA_URL, $options);
			Log::info('[Stream Target CREATE] - Finished');
			return $response->getStatusCode();
		}
    }

	/**
	 * @return string
	 */
	public function deleteStreamTarget(  )
	{
		Log::info('[Stream Target DELETE] - Started');
		$response = $this->_httpClient->delete( self::WOWZA_URL . '/' . $this->_streamTargetType . '-' . str_replace( '/', '-', $this->_streamName ));
		Log::info('[Stream Target DELETE] - Finished');
		return $response->getStatusCode();
	}

}
