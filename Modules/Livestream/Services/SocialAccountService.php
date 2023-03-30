<?php

namespace Modules\Livestream\Services;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Modules\Livestream\SocialAccount;
use Modules\Livestream\StreamIntegration;

class SocialAccountService extends Service
{
    private $_socialAccount;

    /**
     * StreamService constructor.
     *
     * @param  StreamIntegration  $streamIntegration
     */
    public function __construct(SocialAccount $socialAccount = null)
    {
        if (! empty($socialAccount)) {
            $this->_socialAccount = $socialAccount;
        }
    }

    /**
     * Create a Live Video on a Facebook Stream Integration
     *
     * @param  array  $params
     * @return \Facebook\FacebookResponse
     *
     * @throws \Facebook\Exceptions\FacebookResponseException
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function getFacebookPages($params = [])
    {
        try {
            if (empty($this->_socialAccount) || empty($this->_socialAccount->id)) {
                throw new ModelNotFoundException('Social Account not found');
            }
            $fb = new \Facebook\Facebook([
                'app_id' => env('FACEBOOK_APP_ID'),
                'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
                'default_graph_version' => 'v' . env('FACEBOOK_API_VERSION'),
            ]);
            if (! empty($params['access_token'])) {
                $access_token = $params['access_token'];
            } else {
                $access_token = $this->_socialAccount->token;
            }

            return $fb->get('me/accounts?access_token=' . $access_token)->getDecodedBody()['data'];
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
}