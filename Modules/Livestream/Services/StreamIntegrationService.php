<?php

namespace Modules\Livestream\Services;

use Exception;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookResponse;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Modules\Livestream\LivestreamAccount;
use Modules\Livestream\StreamIntegration;

class StreamIntegrationService extends Service
{
    private $_livestreamAccount;
    private $_streamIntegration;
    private $_team;
    private $_httpClient;

    /**
     * StreamService constructor.
     *
     * @param StreamIntegration $streamIntegration
     */
    public function __construct(LivestreamAccount $LivestreamAccount, StreamIntegration $streamIntegration = null)
    {
        $this->_livestreamAccount = $LivestreamAccount;
        $this->_team = $LivestreamAccount->team;
        if (!empty($streamIntegration)) {
            $this->_streamIntegration = $streamIntegration;
        }

        $config = [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ];
        $this->_httpClient = new Client([$config]);
    }

    /**
     * Set the Stream Integration
     */
    public function setStreamIntegration(StreamIntegration $streamIntegration)
    {
        $this->_streamIntegration = $streamIntegration;
    }

    /**
     * Get Live Video Stream Name from Facebook
     *
     * @param array $params
     * @return string
     *
     * @throws FacebookResponseException
     * @throws FacebookSDKException
     */
    public function getFacebookLiveVideoStreamName($params = [])
    {
        Log::info('[FB Live Get Live Video Stream Name] - Started');
        $response = $this->createFacebookLiveVideo($params);
        if (!empty($response)) {
            $streamURL = $response['secure_stream_url'];
            $streamName = trim(substr($streamURL, strpos($streamURL, 'rtmp/')), 'rtmp/');
            Log::info('[FB Live Get Live Video Stream Name] - Finished: Stream Name: ' . $streamName);
        }

        return $streamName;
    }

    /**
     * Create a Live Video on a Facebook Stream Integration
     *
     * @param array $params
     * @return FacebookResponse
     *
     * @throws FacebookResponseException
     * @throws FacebookSDKException
     */
    public function createFacebookLiveVideo($params = [], $teamObject = null)
    {
        try {
            $fb = new Facebook([
                'app_id' => env('FACEBOOK_APP_ID'),
                'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
                'default_graph_version' => 'v' . env('FACEBOOK_API_VERSION'),
            ]);
            if (empty($teamObject)) {
                if (empty($this->_streamIntegration) || empty($this->_streamIntegration->id)) {
                    throw new ModelNotFoundException('Stream Integration not found');
                }
                $teamObject = $this->_streamIntegration->provider_team_object;
            }

            return $fb->post($teamObject['id'] . '/live_videos', $params,
                $teamObject['access_token'])->getDecodedBody();
        } catch (FacebookResponseException $e) {
            Log::error('Graph returned an error: ' . $e->getMessage());
            throw $e;
        } catch (FacebookSDKException $e) {
            Log::error('Facebook SDK returned an error: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error(__CLASS__ . ': ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update a Live Video on a Facebook Stream Integration
     *
     * @param array $params
     * @return FacebookResponse
     *
     * @throws FacebookResponseException
     * @throws FacebookSDKException
     */
    public function updateFacebookLiveVideo($params = [], $teamObject = null)
    {
        try {
            $fb = new Facebook([
                'app_id' => env('FACEBOOK_APP_ID'),
                'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
                'default_graph_version' => 'v' . env('FACEBOOK_API_VERSION'),
            ]);
            if (empty($teamObject)) {
                if (empty($this->_streamIntegration) || empty($this->_streamIntegration->id)) {
                    throw new ModelNotFoundException('Stream Integration not found');
                }
                $teamObject = $this->_streamIntegration->provider_team_object;
            }

            return $fb->post($params['video_id'], $params, $teamObject['access_token'])->getDecodedBody();
        } catch (FacebookResponseException $e) {
            $message = $e->getMessage();
            Log::error('Graph returned an error: ' . $message);
            // We don't want to throw an error if the facebook video doesn't exist anymore, just in case someone deleted it on facebook
            if (!empty($message) && !str_contains($message, 'does not exist')) {
                throw $e;
            }
        } catch (FacebookSDKException $e) {
            Log::error('Facebook SDK returned an error: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error(__CLASS__ . ': ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a Live Video on a Facebook account
     *
     * @param array $params
     * @return FacebookResponse
     *
     * @throws FacebookResponseException
     * @throws FacebookSDKException
     */
    public function deleteFacebookLiveVideo($params = [], $teamObject = null)
    {
        try {
            $fb = new Facebook([
                'app_id' => env('FACEBOOK_APP_ID'),
                'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
                'default_graph_version' => 'v' . env('FACEBOOK_API_VERSION'),
            ]);
            if (empty($teamObject)) {
                if (empty($this->_streamIntegration) || empty($this->_streamIntegration->id)) {
                    throw new ModelNotFoundException('Stream Integration not found');
                }
                $teamObject = $this->_streamIntegration->provider_team_object;
            }

            return $fb->delete($params['video_id'], $params, $teamObject['access_token'])->getDecodedBody();
        } catch (FacebookResponseException $e) {
            $message = $e->getMessage();
            Log::error('Graph returned an error: ' . $message);
            // We don't want to throw an error if the facebook video doesn't exist anymore, just in case someone deleted it on facebook
            if (!empty($message) && !str_contains($message, 'does not exist')) {
                throw $e;
            }
        } catch (FacebookSDKException $e) {
            Log::error('Facebook SDK returned an error: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error(__CLASS__ . ': ' . $e->getMessage());
            throw $e;
        }
    }
}
