<?php

namespace Modules\Jobs\Google;

use Google_Client;
use GuzzleHttp\ClientInterface;

class Client
{
    protected $client;

    public function __construct($config)
    {
        $this->client = new Google_Client;

        // service_account_file.json is the private key that you created for your service account.
        $this->client->setAuthConfig(__DIR__ . '/../../' . $config['service']['file']);
        $this->client->addScope('https://www.googleapis.com/auth/indexing');
    }

    public function authorize(): ClientInterface
    {
        return $this->client->authorize();
    }
}
