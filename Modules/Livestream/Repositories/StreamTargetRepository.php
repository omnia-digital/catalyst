<?php

namespace Modules\Livestream\Repositories;

use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Modules\Livestream\Http\Requests\Request;
use Modules\Livestream\Services\MuxService;
use Modules\Livestream\Stream;
use Modules\Livestream\StreamTarget;

class StreamTargetRepository
{
    /**
     * Perform a basic Stream Target search.
     *
     * @param string $query
     * @param Authenticatable|null $excludeStreamTarget
     * @return Collection
     */
    public function search($query, $excludeStreamTarget = null)
    {
    }

    public function find($id)
    {
        return Stream::where('id', $id)->with('owner', 'users')->first();
    }

    public function create($params)
    {
        // Setup Params
        $name = $params['name'];
        $stream = $params['stream'];
        $url = $params['url'];
        $stream_key = $params['stream_key'];
        $passthrough = $params['passthrough'];

        // create a stream on Mux
        $mux_service = new MuxService;
        $muxStreamData = $mux_service->createSimulcastTarget($stream->stream_id, $url, $stream_key, $passthrough);

        // then create it on omnia
        $streamParams = [
            'name' => $name,
            'enabled' => true,
            'url' => $url,
            'stream_key' => $stream_key,
            'passthrough' => $passthrough,
            'status' => $muxStreamData->getStatus(),
            'mux_simulcast_target_id' => $muxStreamData->getId(),
            'stream_id' => $stream->id, // Omnia Stream id to create a foreign key
            //                'status',
            //                'stream_integration_id' => null,
        ];
        $streamTarget = StreamTarget::create($streamParams);

        return $streamTarget;
    }

    public function update(StreamTarget $stream_target, Request $request)
    {
        // if enabled
        // check if exists on mux
        // if not, create it
        // if disabled
        // delete from mux

//            if ($request->has('enabled')) {
//                $enabled = $request->get('enabled');
//
//                $mux_service   = new MuxService();
//                if (empty($enabled)) {
//                    $muxStreamData = $mux_service->deleteSimulcastTargets($stream_target->stream->stream_id, $stream_target->mux_simulcast_target_id);
//                } else {
//                    $muxStreamData = $mux_service->getSimulcastTargets($stream_target->stream->stream_id, $stream_target->mux_simulcast_target_id);
//                    // @TODO [Josh] - create one
//                }
//            }

        $stream_target->update($request);

        // update on mux
        // if disabled, then delete from mux
        // if enabled, create on mux
    }

    /**
     * Destroy one or more Stream Targets
     */
    public function destroy($ids)
    {
        if (is_array($ids)) {
            foreach ($ids as $id) {
                try {
                    $this->delete($id);
                } catch (Exception $e) {
                    // @TODO [Josh] -  return an array of errors so we know which ones failed
                }
            }
        } else {
            $result = $this->delete($ids);
        }

        return $result;
    }

    /**
     * Delete One Stream Target
     */
    public function delete($stream_target)
    {
        if (is_numeric($stream_target)) {
            $stream_target = StreamTarget::findOrFail($stream_target);
        }
        if (!($stream_target instanceof StreamTarget)) {
            throw new Exception('Could not find Stream Target to delete it');
        }

        // Delete from Mux
        // @TODO [Josh] - change to destroy on mux (if it exists) it could have already been deleted if disabled already
        $mux_service = new MuxService;
        $muxStreamData = $mux_service->deleteSimulcastTargets($stream_target->stream->stream_id,
            $stream_target->mux_simulcast_target_id);

        // @TODO [Josh] - change so it only deletes on Omnia if successfully deleted from Mux
        return $stream_target->delete();
    }
}
