<?php namespace Modules\Subscriptions\Support;

use Illuminate\Support\Facades\Http;

class FormAssembly
{
    private $accessToken;

    public function __construct()
    {
        $this->accessToken = $this->getAccessToken();
    }

    private function loginUrl() {
        return 'https://app.formassembly.com/oauth/login' . $this->getQueryString();
    }

    private function getAccessToken()
    {
        $response = Http::get($this->loginUrl());
        $code = $response->get('code');

        $response = Http::post('https://app.formassembly.com/oauth/access_token', [
            'grant_type' => 'authorization_code',
            'type' => 'web_server',
            'client_id' => config('services.form_assembly.client_id'),
            'client_secret' => config('services.form_assembly.client_secret'),
            'redirect_uri' => config('services.form_assembly.return_url'),
            'code' => $code,
        ]);

        return $response['access_token'];
    }

    private function getQueryString()
    {
        return '?' . http_build_query([
            'type' => 'web',
            'client_id' => config('services.form_assembly.client_id'),
            'redirect_uri' => config('services.form_assembly.return_url'),
            'response_type' => 'code',
        ]);
    }
}


