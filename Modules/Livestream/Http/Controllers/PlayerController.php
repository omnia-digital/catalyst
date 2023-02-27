<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\EnvironmentDetector;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Exceptions\UnsupportedBroswerException;
use App\Services\PlayerService;
use App\Http\Requests\PlayerRequest;
use App\LivestreamAccount;
use App\Player;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\LivestreamController;
use App\Video;
use App\WowzaMediaServer;
use App\WowzaVhost;
use App\WowzaPublisher;
use App\WowzaVhostHostPort;
use App\Services\StreamService;


class PlayerController extends LivestreamController
{
    protected $_playerService;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $livestreamAccount = $this->_livestreamAccount;
        $players = $this->_livestreamAccount->players;

//        $players->load('embedCode');



        return $players;

//        return view('livestream::player/index', compact('players'));
    }

    /**
     * Show the form for creating a new player
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $LivestreamAccounts = Auth::user()->LivestreamAccounts;
//        $events = collect();
//        foreach ($LivestreamAccounts as $LivestreamAccount) {
//            $events->push($LivestreamAccount->events->all());
//        }
//        $events = $events->flatten()->lists('title','id');
        // @TODO [Josh] - The lists method on the Collection, query builder and Eloquent query builder objects has been renamed to pluck. The method signature remains the same.
//        $LivestreamAccounts = $LivestreamAccounts->flatten()->pluck('account_name','id');

        return view('livestream::player/create');
    }

    /**
     * Store a newly created Player in storage.
     *
     * @param PlayerRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PlayerRequest $request)
    {
        $request = $request->all();
        $request['livestream_account_id'] = $this->_livestreamAccount->id;
        $player = Player::create($request);

        return response()->json([
            'success' => true,
            'data' => $player
        ]);

//        flash()->overlay("Your new Player " . $player->name . " has been created! <br/> Let's get started and create your first Event!", 'Congratulations!');

//        return redirect(route('livestream::player.edit',[$player->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  Player  $player
     * @return \Illuminate\Http\Response
     */
    public function show(Player $player)
    {
        $player->embed_code = $player->embed_code;

        $livestreamAccount = $player->livestreamAccount;

        // if livestream account is currently streaming
        $streamService = new StreamService($livestreamAccount);
        if ($streamService->isCurrentlyStreaming()) {
            if ($livestreamAccount->mux_livestream_active == true) {
                // Mux Live stream
                $streams = $livestreamAccount->streams;
                if ( ! empty($streams) && $streams->isNotEmpty()) {
                    $stream      = $streams->first();
                    $playbackUrl = $stream->default_playback_url;
                }

            } else {
                // Wowza Live stream
                $playbackUrl = $streamService->getLivestreamURL();
            }

            $player->startingVideo = [
                'playback_url' => $playbackUrl,
                'image_url'    => $livestreamAccount->before_live_image
            ];
        } else {
            $player->startingEpisode = $livestreamAccount->episodes()->where('is_published',true)->latest('date_recorded')->with('videos')->first();
        }

        return $player;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function edit(Player $player)
    {
        $this->_playerService = new PlayerService();

        // @TODO [Josh] - I want to be able to decide if that Player uses Live Episodes or not. If a player is going to have live, just add live playlist to that player automatically *user should be able to decide which streams to use (future release)*

        // to be able to look at a player and decide what goes on it.
            // livestream from this stream
            // these past episodes with filters: Sundays, wednesdays, specific  , specific types of services?? or schedules
            // maybe create a mysql view to have past episodes

        // The only point of playlists that I see is reusability from a player to a podcast/rss feed, also making a live playlist would make it so you could give the feed whatever name you want.
        // playlist should just be a query of episodes if its dynamic
        // if playlist is static, then the episodes need to be mapped through a table eg. livestream_playlist_episodes

//        $groups = Event::lists('name', 'id');
//
//        $player = Player::findorFail($id);
//        $LivestreamAccounts = Auth::user()->LivestreamAccounts;
//        $events = collect();
//        foreach ($LivestreamAccounts as $LivestreamAccount) {
//            $events->push($LivestreamAccount->events->all());
//        }
//        $events = $events->flatten()->lists('title', 'id');
//
//        $LivestreamURL = "rtmp://52.53.215.51:1935/asdf_live/_definst_/flv:1/2.flv";
        $streamService = new StreamService($this->_livestreamAccount, $player,'all');
//        $Livestreams = $streamService->getDVRLivestreams();
//	    $Livestreams = $Livestreams->first()->get('all'); // @TODO [Josh] - this is because I don't know how to handle multiple streams right now on the JWPlayer * I will remove this once I can
	    $recentVideoPlaylist = $this->_playerService->getPlayerPlaylist($this->_livestreamAccount,$streamService);
	    $LivestreamPlaylist = $this->_playerService->getPlayerPlaylist($this->_livestreamAccount,$streamService);
        $LivestreamAccountId = $this->_livestreamAccount->id;
//
//
//	    $LivestreamPlaylist = $this->_playerService->formatForJWPlayerPlaylist($VodStreams);
//        $mostRecentVideo = $this->_livestreamAccount->mostRecentVideo();
//        $videos = collect([$mostRecentVideo]);
//        $recentVideoPlaylist = $this->_playerService->formatForJWPlayerPlaylist($videos);


        return $player;
//        return view('livestream::player/edit',compact('player','LivestreamPlaylist','LivestreamAccountId','recentVideoPlaylist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlayerRequest|Request $request
     * @param  Player               $player
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PlayerRequest $request, Player $player)
    {
        $request = $request->all();
        if ($request['embed_code']) {
            unset($request['embed_code']);
        }
        $player->update($request);

//        $player->sync($request->input('group_list'));

        return $player;
//        return \Redirect::back()->with('message','Operation Successful !');
    }

    /**
     * Remove the Player
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = Player::destroy($id);
        return $count;
//        return redirect(route("livestream::livestream"));
    }

	/**
	 * Returns the player view for a Web Page through an iframe
     * This is usually called from the embed code on an external website
	 *
	 * @param $livestreamAccountId
	 * @param $playerId
	 *
	 * @return View
	 * @throws \Exception
	 */
    public function embedPlayer( $livestreamAccountId, Player $player )
    {
	    try {
            $this->_playerService = new PlayerService();

            $errors = collect();
            // this should just be a view with just the player that was requested.
		    $livestreamAccount = LivestreamAccount::findOrFail( $livestreamAccountId );

		    $streamService  = new StreamService( $livestreamAccount, $player );
		    $playlist = $this->_playerService->getPlayerPlaylist($livestreamAccount,$streamService);

	    } catch (\Exception $e) {
            Log::error('Livestream Account: ' . $livestreamAccountId . ' : ' . $e->getMessage());
            $errors->push($e->getMessage(), $e->getCode(), $e);
	    }
        return view( 'livestream::player/embed', compact( 'playlist', 'errors' ) );
    }

    /**
     * Return the Player Embed Code
     */
    public function getEmbedCode(Player $player)
    {
        return response()->json([
            'success' => true,
            'data' => $player->embed_code
        ]);
    }

    /**
     * Show what a website embedded player looks like (used for testing only)
     * @param $LivestreamAccountId
     * @param $playerId
     * @return View
     */
    public function myWebsite($LivestreamAccountId, $playerId)
    {
        return view('livestream::player/mywebsite', compact('LivestreamAccountId', 'playerId'));
    }
}
