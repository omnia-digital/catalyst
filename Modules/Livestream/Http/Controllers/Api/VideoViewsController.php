<?php namespace Modules\Livestream\Http\Controllers\Api;

use Modules\Livestream\Events\EpisodeViewedEvent;
use Modules\Livestream\Http\Controllers\Controller;
use Modules\Livestream\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoViewsController extends Controller
{
    public function dispatchVideoView(Request $request): Response
    {
        $episode = Episode::find($request->episode_id);

        if ($episode) {
            event(new EpisodeViewedEvent($episode));
        }

        return response()->noContent();
    }
}
