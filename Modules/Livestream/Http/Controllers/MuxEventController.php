<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Video\VideoAssetCreated;
use App\Events\Video\VideoAssetDeleted;
use App\Events\Video\VideoAssetErrored;
use App\Events\Video\VideoAssetLivestreamCompleted;
use App\Events\Video\VideoAssetMasterDeleted;
use App\Events\Video\VideoAssetMasterErrored;
use App\Events\Video\VideoAssetMasterPreparing;
use App\Events\Video\VideoAssetMasterReady;
use App\Events\Video\VideoAssetReady;
use App\Events\Video\VideoAssetStaticDeleted;
use App\Events\Video\VideoAssetStaticErrored;
use App\Events\Video\VideoAssetStaticPreparing;
use App\Events\Video\VideoAssetStaticReady;
use App\Events\Stream\StreamActive;
use App\Events\Stream\StreamConnected;
use App\Events\Stream\StreamCreated;
use App\Events\Stream\StreamDeleted;
use App\Events\Stream\StreamDisconnected;
use App\Events\Stream\StreamIdle;
use App\Events\Stream\StreamRecording;
use App\Events\Stream\StreamUpdated;
use App\Events\Video\VideoAssetUpdated;
use App\Events\Video\VideoUploadAssetCreated;
use App\Events\Video\VideoUploadCancelled;
use App\Events\Video\VideoUploadCreated;
use App\Events\Video\VideoUploadErrored;

class MuxEventController extends LivestreamController
{

    public function testEvent()
    {
        $data = json_decode("{\"accessor\":\"\",\"accessor_source\":\"\",\"attempts\":[],\"created_at\":\"2020-03-24T21:37:59.000000Z\",\"data\":{\"active_asset_id\":\"F53qM1uHk4UA01011fe00h9Tufb6InlE7Jc\",\"connected\":true,\"created_at\":1585085671,\"id\":\"RVwmVtSN1Iz102GGFmrDuuKLWTjLX8HzY\",\"new_asset_settings\":{\"playback_policies\":[\"public\"]},\"playback_ids\":[{\"id\":\"adMtNTYQhqXDuuMXV6NgXWOs24Uaqw1u\",\"policy\":\"public\"}],\"recent_asset_ids\":[\"F53qM1uHk4UA01011fe00h9Tufb6InlE7Jc\"],\"reconnect_window\":60,\"recording\":true,\"status\":\"active\",\"stream_key\":\"26ae82bd-19ee-192e-fd53-bb41d10c12e8\"},\"environment\":{\"id\":\"pcg9mg\",\"name\":\"Development\"},\"id\":\"bae68abf-bb91-47e9-b801-b27d430cd93e\",\"object\":{\"id\":\"RVwmVtSN1Iz102GGFmrDuuKLWTjLX8HzY\",\"type\":\"live\"},\"request_id\":\"\",\"type\":\"video.live_stream.active\"}",true);

        event(new StreamActive($data));

    }


    /**
     * Handle an incoming Episode Event by passing it off to the event internally, which can then be handled by an Event listener. This needs to be extremely fast since we may need to handle many
     * requests
     * simlutaneously
     *
     * @param Request $request
     */
	public function handle(Request $request)
	{
	    if (!$request->has('type')) {
	        return;
        }

	    $event = $request->get('type');
	    $data = $request->all();
	    switch($event) {
            //        Asset Events //
            case 'video.asset.created':
                event(new VideoAssetCreated($data));
                break;
            case 'video.asset.ready':
                event(new VideoAssetReady($data));
                break;
            case 'video.asset.errored':
                event(new VideoAssetErrored($data));
                break;
            case 'video.asset.deleted':
                event(new VideoAssetDeleted($data));
                break;
            case 'video.asset.updated':
                event (new VideoAssetUpdated($data));
                break;
            case 'video.asset.live_stream_completed':
                event(new VideoAssetLivestreamCompleted($data));
                break;
            case 'video.asset.static_renditions.ready':
                event(new VideoAssetStaticReady($data));
                break;
            case 'video.asset.static_renditions.preparing':
                event(new VideoAssetStaticPreparing($data));
                break;
            case 'video.asset.static_renditions.deleted':
                event(new VideoAssetStaticDeleted($data));
                break;
            case 'video.asset.static_renditions.errored':
                event(new VideoAssetStaticErrored($data));
                break;
            case 'video.asset.master.ready':
                event(new VideoAssetMasterReady($data));
                break;
            case 'video.asset.master.preparing':
                event(new VideoAssetMasterPreparing($data));
                break;
            case 'video.asset.master.deleted':
                event(new VideoAssetMasterDeleted($data));
                break;
            case 'video.asset.master.errored':
                event(new VideoAssetMasterErrored($data));
                break;


            //        Upload Events //
            case 'video.upload.asset_created':
                event(new VideoUploadAssetCreated($data));
                break;
            case 'video.upload.cancelled':
                event(new VideoUploadCancelled($data));
                break;
            case 'video.upload.created':
                event(new VideoUploadCreated($data));
                break;
            case 'video.upload.errored':
                event(new VideoUploadErrored($data));
                break;

            //        Live Stream Events //
            case 'video.live_stream.created':
                event(new StreamCreated($data));
                break;
            case 'video.live_stream.connected':
                event(new StreamConnected($data));
                break;
            case 'video.live_stream.recording':
                event(new StreamRecording($data));
                break;
            case 'video.live_stream.active':
                event(new StreamActive($data));
                break;
            case 'video.live_stream.disconnected':
                event(new StreamDisconnected($data));
                break;
            case 'video.live_stream.idle':
                event(new StreamIdle($data));
                break;
            case 'video.live_stream.updated':
                event(new StreamUpdated($data));
                break;
            case 'video.live_stream.deleted':
                event(new StreamDeleted($data));
                break;

            //        Simulcast Target Events //
            //        video.live_stream.simulcast_target.created
            //        video.live_stream.simulcast_target.idle
            //        video.live_stream.simulcast_target.starting
            //        video.live_stream.simulcast_target.broadcasting
            //        video.live_stream.simulcast_target.errored
            //        video.live_stream.simulcast_target.deleted
        }
            // Sample response
//                {
//                      "type": "video.asset.ready",
//                      "request_id": null,
//                      "object": {
//                        "type": "asset",
//                        "id": "0201p02fGKPE7MrbC269XRD7LpcHhrmbu0002"
//                      },
//                      "id": "3a56ac3d-33da-4366-855b-f592d898409d",
//                      "environment": {
//                        "name": "Demo pages",
//                        "id": "j0863n"
//                      },
//                      "data": {
//                        "tracks": [
//                          {
//                            "type": "video",
//                            "max_width": 1280,
//                            "max_height": 544,
//                            "max_frame_rate": 23.976,
//                            "id": "0201p02fGKPE7MrbC269XRD7LpcHhrmbu0002",
//                            "duration": 153.361542
//                          },
//                          {
//                            "type": "audio",
//                            "max_channels": 2,
//                            "max_channel_layout": "stereo",
//                            "id": "FzB95vBizv02bYNqO5QVzNWRrVo5SnQju",
//                            "duration": 153.361497
//                          }
//                        ],
//                        "status": "ready",
//                        "max_stored_resolution": "SD",
//                        "max_stored_frame_rate": 23.976,
//                        "id": "0201p02fGKPE7MrbC269XRD7LpcHhrmbu0002",
//                        "duration": 153.361542,
//                        "created_at": "2018-02-15T01:04:45.000Z",
//                        "aspect_ratio": "40:17"
//                      },
//                      "created_at": "2018-02-15T01:04:45.000Z",
//                      "accessor_source": null,
//                      "accessor": null
//                }
        return;
	}
}
