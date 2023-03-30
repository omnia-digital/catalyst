<?php

namespace Modules\Livestream\Repositories;

    use Modules\Livestream\LivestreamAccount;
    use Modules\Livestream\PlaybackId;
    use Modules\Livestream\Services\MuxService;
    use Modules\Livestream\Stream;

    class StreamRepository
    {
        /**
         * Perform a basic Stream search.
         *
         * @param  string  $query
         * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $excludeStream
         * @return \Illuminate\Database\Eloquent\Collection
         */
        public function search($query, $excludeStream = null)
        {
        }

        public function find($id)
        {
            return Stream::where('id', $id)->with('owner', 'users')->first();
        }

        public function forLivestreamAccount($livestream_account)
        {
            return $livestream_account->streams;
        }

        public function create(LivestreamAccount $livestream_account, $create_on_mux = true, $streamParams = null)
        {
            // create a stream on Mux
            $mux_service = new MuxService;
            $muxStreamData = $mux_service->createLivestreamRequest();

            // then create it on omnia
            $streamParams = [
                'stream_id' => $muxStreamData->getId(),
                'stream_key' => $muxStreamData->getStreamKey(),
                'status' => $muxStreamData->getStatus(),
                'reconnect_window' => $muxStreamData->getReconnectWindow(),
                'livestream_account_id' => $livestream_account->id,
            ];
            $stream = Stream::create($streamParams);

            foreach ($muxStreamData->getPlaybackIds() as $muxPlaybackId) {
                $playbackId = PlaybackId::create([
                    'playback_id' => $muxPlaybackId->getId(),
                    'policy' => $muxPlaybackId->getPolicy(),
                    'playbackable_type' => Stream::class,
                    'playbackable_id' => $stream->id,
                ]);
            }

            return $stream;
        }
    }
