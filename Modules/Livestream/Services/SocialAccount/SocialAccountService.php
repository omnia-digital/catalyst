<?php

namespace Modules\Livestream\Services\SocialAccount;

use Exception;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Facebook\FacebookResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Modules\Livestream\Models\SocialAccount;

class SocialAccountService
{
    private $_socialAccount;

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
     * @return FacebookResponse
     *
     * @throws FacebookResponseException
     * @throws FacebookSDKException
     */
    public function getFacebookPages($params = [])
    {
        try {
            if (empty($this->_socialAccount) || empty($this->_socialAccount->id)) {
                throw new ModelNotFoundException('Social Account not found');
            }
            $fb = new Facebook([
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
}
