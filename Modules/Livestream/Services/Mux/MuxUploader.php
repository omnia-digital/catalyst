<?php namespace App\Services\Mux;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use MuxPhp\Api\DirectUploadsApi;
use MuxPhp\Configuration;
use MuxPhp\Models\CreateUploadRequest;

class MuxUploader
{
    protected DirectUploadsApi $directUploadsApi;

    public function __construct(Client $client, Configuration $configuration)
    {
        $this->directUploadsApi = new DirectUploadsApi($client, $configuration);
    }

    public function make(): array
    {
        $upload = $this->directUploadsApi->createDirectUpload(new CreateUploadRequest([
            'cors_origin'        => config('app.url'),
            'new_asset_settings' => [
                'passthrough'     => $omniaVideoId = Str::random(),
                'playback_policy' => 'public'
            ]
        ]));

        return [
            'id'   => $omniaVideoId,
            'data' => $upload->getData()
        ];
    }
}
