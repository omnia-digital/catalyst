<?php namespace App\Http\Controllers\Api;

use App\Events\EpisodeViewedEvent;
use App\Http\Controllers\Controller;
use App\Models\Episode;
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
