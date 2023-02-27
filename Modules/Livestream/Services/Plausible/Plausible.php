<?php

namespace Modules\Livestream\Services\Plausible;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Plausible
{
    protected PendingRequest $httpClient;

    public function __construct()
    {
        $this->httpClient = Http::withHeaders([
            'X-Forwarded-For' => request()->ip(),
            'User-Agent' => request()->userAgent(),
            'Content-Type' => 'application/json'
        ]);
    }

    public function dispatchCustomEvent(string $name, array $props = []): void
    {
        $data = array_merge([
            'name' => $name,
            'props' => $props
        ], $this->defaultEventData());

        $this->httpClient
            ->post($this->apiUrl('api/event'), $data)
            ->throw();
    }

    protected function apiUrl(string $path): string
    {
        return 'https://plausible.io' . Str::start($path, '/');
    }

    protected function defaultEventData(): array
    {
        return [
            'domain' => config('plausible.domain'),
            'url' => request()->fullUrl(),
            'referrer' => request()->headers->get('referer'),
        ];
    }
}
