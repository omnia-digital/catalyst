<?php

namespace Modules\Livestream\Http\Controllers;

use Modules\Livestream\Http\Requests\PlaylistRequest;
use Modules\Livestream\LivestreamAccount;
use Modules\Livestream\Playlist;
use Auth;
use Illuminate\Http\Request;
use Modules\Livestream\Http\Requests;
use Modules\Livestream\Http\Controllers\LivestreamController;
use Modules\Livestream\Services\PlayerService;
use Modules\Livestream\WowzaMediaServer;
use Modules\Livestream\WowzaVhost;
use Modules\Livestream\WowzaPublisher;
use Modules\Livestream\WowzaVhostHostPort;


class PlaylistController extends LivestreamController
{

    /**
     * Create a PlaylistController Instance
     */
    public function __construct ()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('livestream::playlist/index');
    }

    /**
     * Show the form for creating a new playlist.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $LivestreamAccounts = Auth::user()->LivestreamAccounts;
//        $events = collect();
//        foreach ($LivestreamAccounts as $LivestreamAccount) {
//            $events->push($LivestreamAccount->events->all());
//        }
//        $events = $events->flatten()->lists('title','id');
        $LivestreamAccounts = $LivestreamAccounts->flatten()->lists('account_name','id');

        return view('livestream::playlist/create', compact('LivestreamAccounts'));
    }

    /**
     * Store a newly created Playlist in storage.
     *
     * @param PlaylistRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PlaylistRequest $request)
    {
        $request = $request->all();
        $playlist = Playlist::create([
            'name' => $request['playlist_name'],
            'type' => $request['playlist_type'],
            'account_id' => $request['LivestreamAccount']
        ]);

        flash()->overlay("Your new Playlist " . $playlist->name . " has been created! <br/> Let's get started and create your first Event!", 'Congratulations!');

        return redirect()->route('livestream::playlist.edit', $playlist);
    }

	/**
	 * Display the specified resource.
	 *
     * @param  Playlist  $playlist
	 * @return \Illuminate\Http\Response
	 */
    public function show($id)
    {
        $playlist = Playlist::findOrFail($id);
        return view('livestream::playlist/profile', compact('$playlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param Playlist $playlist
     */
    public function edit($id)
    {
//        $groups = Event::lists('name', 'id');

        $playlist = Playlist::findorFail($id);
        $LivestreamAccounts = Auth::user()->LivestreamAccounts;
        $events = collect();
        foreach ($LivestreamAccounts as $LivestreamAccount) {
            $events->push($LivestreamAccount->events->all());
        }
        $events = $events->flatten()->lists('title', 'id');

        return view('livestream::playlist/edit', compact('playlist', 'events'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlaylistRequest|Request $request
     * @param  Playlist               $playlist
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PlaylistRequest $request, Playlist $playlist)
    {
        $request = $request->all();
        $playlist->update($request);

//        $playlist->sync($request->input('group_list'));

        return \Redirect::back()->with('message','Operation Successful !');
    }

    /**
     * Remove the LivestreamAccount and associated files from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    /**
     * @param $type
     * @return string
     */
	public function getPlaylist($LivestreamAccountId, $type = null)
	{
        return $this->getLiveVodPlaylist($LivestreamAccountId);
    }

	/**
	 * Get Live & Vod Playlist
	 *
	 * @param $LivestreamAccountId
	 *
	 * @return
	 */
	public function getLiveVodPlaylist($LivestreamAccountId)
	{
		// Get LivestreamAcount
		$LivestreamAccount = LivestreamAccount::findOrFail($LivestreamAccountId);

		$playerService = new PlayerService();

		return $playerService->getPlayerPlaylist($LivestreamAccount);
	}

	/**
	 * Get Vod Playlist
	 * @param $LivestreamAccountId
	 *
	 * @return
	 */
	public function getVodPlaylist($LivestreamAccountId)
	{
		// Get LivestreamAcount
		$LivestreamAccount = LivestreamAccount::findOrFail($LivestreamAccountId);

		$playerService = new PlayerService();
		return $playerService->getLiveAndVodPlaylist($LivestreamAccount);
	}

	/**
	 * Get Live Playlist
	 *
	 * @param $LivestreamAccountId
	 *
	 * @return
	 */
	public function getLivePlaylist($LivestreamAccountId)
	{
		// Get LivestreamAcount
		$LivestreamAccount = LivestreamAccount::findOrFail($LivestreamAccountId);

		$playerService = new PlayerService();
		return $playerService->getLiveAndVodPlaylist($LivestreamAccount);
	}

}
