<?php

namespace Modules\Livestream\Services\SocialAccount;

use Exception;
use Facebook\Facebook;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StreamIntegrationService
{
    public Facebook $fb;

    public function __construct()
    {
        $this->fb = new Facebook([
            'app_id' => config('services.facebook.app_id'),
            'app_secret' => config('services.facebook.app_secret'),
            'default_graph_version' => 'v' . config('services.facebook.default_graph_version'),
        ]);
    }

    /**
     * Get Live Video Stream Name from Facebook
     *
     * @param  array  $params
     * @return ?string
     *
     * @throws \Facebook\Exceptions\FacebookResponseException
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getFacebookLiveVideoStreamName($params = [])
    {
        Log::info('[FB Live Get Live Video Stream Name] - Started');

        $response = $this->createFacebookLiveVideo($params);

        if (! empty($response)) {
            $streamURL = $response['secure_stream_url'];
            $streamName = trim(substr($streamURL, strpos($streamURL, 'rtmp/')), 'rtmp/');
            Log::info('[FB Live Get Live Video Stream Name] - Finished: Stream Name: ' . $streamName);
        }

        return $streamName ?? null;
    }

    /**
     * Create a Live Video on a Facebook Stream Integration
     *
     * @param  array  $params
     * @return array
     *
     * @throws \Facebook\Exceptions\FacebookResponseException
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function createFacebookLiveVideo($params = [], $teamObject = null)
    {
        try {
            if (empty($teamObject)) {
                if (empty($this->_streamIntegration) || empty($this->_streamIntegration->id)) {
                    throw new ModelNotFoundException('Stream Integration not found');
                }
                $teamObject = $this->_streamIntegration->provider_team_object;
            }

            return $this->fb->post($teamObject['id'] . '/live_videos', $params, $teamObject['access_token'])->getDecodedBody();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            Log::error('Graph returned an error: ' . $e->getMessage());
            throw $e;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
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
     * @param  array  $params
     * @return array
     *
     * @throws \Facebook\Exceptions\FacebookResponseException
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function updateFacebookLiveVideo($params = [], $teamObject = null)
    {
        try {
            if (empty($teamObject)) {
                if (empty($this->_streamIntegration) || empty($this->_streamIntegration->id)) {
                    throw new ModelNotFoundException('Stream Integration not found');
                }
                $teamObject = $this->_streamIntegration->provider_team_object;
            }

            return $this->fb->post($params['video_id'], $params, $teamObject['access_token'])->getDecodedBody();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            $message = $e->getMessage();
            Log::error('Graph returned an error: ' . $message);
            // We don't want to throw an error if the facebook video doesn't exist anymore, just in case someone deleted it on facebook
            if (! str_contains($message, 'does not exist')) {
                throw $e;
            }
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
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
     * @param  array  $params
     * @return array
     *
     * @throws \Facebook\Exceptions\FacebookResponseException
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function deleteFacebookLiveVideo($params = [], $teamObject = null)
    {
        try {
            if (empty($teamObject)) {
                if (empty($this->_streamIntegration) || empty($this->_streamIntegration->id)) {
                    throw new ModelNotFoundException('Stream Integration not found');
                }
                $teamObject = $this->_streamIntegration->provider_team_object;
            }

            return $this->fb->delete($params['video_id'], $params, $teamObject['access_token'])->getDecodedBody();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            $message = $e->getMessage();
            Log::error('Graph returned an error: ' . $message);
            // We don't want to throw an error if the facebook video doesn't exist anymore, just in case someone deleted it on facebook
            if (! str_contains($message, 'does not exist')) {
                throw $e;
            }
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            Log::error('Facebook SDK returned an error: ' . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error(__CLASS__ . ': ' . $e->getMessage());
            throw $e;
        }
    }
}