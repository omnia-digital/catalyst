<?php namespace App\Actions\Livestream;

use App\Models\Stream;
use App\Models\StreamTarget;
use App\Services\Mux\MuxLivestream;

class CreateStreamTargetAction
{
    public function execute(int|Stream $stream, array $params): StreamTarget
    {
        is_int($stream) && $stream = Stream::find($stream);

        $muxStreamData = app(MuxLivestream::class)->createSimulcastTarget(
            $stream->stream_id,
            $params['url'],
            $params['stream_key'],
            $params['passthrough'] ?? null
        );

        return $stream->streamTargets()->create([
            'name'                    => $params['name'],
            'url'                     => $params['url'],
            'stream_key'              => $params['stream_key'],
            'passthrough'             => $params['passthrough'] ?? null,
            'enabled'                 => true,
            'status'                  => $muxStreamData->getStatus(),
            'mux_simulcast_target_id' => $muxStreamData->getId(),
            'stream_id'               => $stream->id, // Omnia Stream id to create a foreign key
        ]);
    }
}
