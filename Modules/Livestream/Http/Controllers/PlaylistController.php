<?php

namespace Modules\Livestream\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Modules\Livestream\Http\Requests\PlaylistRequest;
use Modules\Livestream\LivestreamAccount;
use Modules\Livestream\Playlist;
use Modules\Livestream\Services\PlayerService;

class PlaylistController extends LivestreamController
{
    /**
     * Create a PlaylistController Instance
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('livestream::playlist/index');
    }

    /**
     * Store a newly created Playlist in storage.
     *
     * @param  PlaylistRequest|Request  $request
     * @return Response
     */
    public function store(PlaylistRequest $request)
    {
        $request = $request->all();
        $playlist = Playlist::create([
            'name' => $request['playlist_name'],
            'type' => $request['playlist_type'],
            'account_id' => $request['LivestreamAccount'],
        ]);

        flash()->overlay('Your new Playlist ' . $playlist->name . " has been created! <br/> Let's get started and create your first Event!",
            'Congratulations!');

        return redirect()->route('livestream::playlist.edit', $playlist);
    }

    /**
     * Show the form for creating a new playlist.
     *
     * @return Response
     */
    public function create()
    {
        $LivestreamAccounts = auth()->user()->LivestreamAccounts;
//        $events = collect();
//        foreach ($LivestreamAccounts as $LivestreamAccount) {
//            $events->push($LivestreamAccount->events->all());
//        }
//        $events = $events->flatten()->lists('title','id');
        $LivestreamAccounts = $LivestreamAccounts->flatten()->lists('account_name', 'id');

        return view('livestream::playlist/create', compact('LivestreamAccounts'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Playlist  $playlist
     * @return Response
     */
    public function show($id)
    {
        $playlist = Playlist::findOrFail($id);

        return view('livestream::playlist/profile', compact('$playlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     *
     * @internal param Playlist $playlist
     */
    public function edit($id)
    {
//        $groups = Event::lists('name', 'id');

        $playlist = Playlist::findorFail($id);
        $LivestreamAccounts = auth()->user()->LivestreamAccounts;
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
     * @param  PlaylistRequest|Request  $request
     * @return Response
     */
    public function update(PlaylistRequest $request, Playlist $playlist)
    {
        $request = $request->all();
        $playlist->update($request);

//        $playlist->sync($request->input('group_list'));

        return Redirect::back()->with('message', 'Operation Successful !');
    }

    /**
     * Remove the LivestreamAccount and associated files from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
    }

    /**
     * @return string
     */
    public function getPlaylist($LivestreamAccountId, $type = null)
    {
        return $this->getLiveVodPlaylist($LivestreamAccountId);
    }

    /**
     * Get Live & Vod Playlist
     */
    public function getLiveVodPlaylist($LivestreamAccountId)
    {
        // Get LivestreamAcount
        $LivestreamAccount = LivestreamAccount::findOrFail($LivestreamAccountId);

        $playerService = new PlayerService;

        return $playerService->getPlayerPlaylist($LivestreamAccount);
    }

    /**
     * Get Vod Playlist
     */
    public function getVodPlaylist($LivestreamAccountId)
    {
        // Get LivestreamAcount
        $LivestreamAccount = LivestreamAccount::findOrFail($LivestreamAccountId);

        $playerService = new PlayerService;

        return $playerService->getLiveAndVodPlaylist($LivestreamAccount);
    }

    /**
     * Get Live Playlist
     */
    public function getLivePlaylist($LivestreamAccountId)
    {
        // Get LivestreamAcount
        $LivestreamAccount = LivestreamAccount::findOrFail($LivestreamAccountId);

        $playerService = new PlayerService;

        return $playerService->getLiveAndVodPlaylist($LivestreamAccount);
    }
}
