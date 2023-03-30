<?php

namespace Modules\Livestream\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Livestream\Dashboard;
use Modules\Livestream\Http\Requests\DashboardRequest;
use Modules\Livestream\Services\PlayerService;
use Modules\Livestream\Services\StreamService;
use Modules\Livestream\Video;

class DashboardController extends LivestreamController
{
    protected $_playerService;

    public function __construct()
    {
        parent::__construct();
        $this->_playerService = new PlayerService;
    }

    /**
     * Display the dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/livestream/');
    }

    /**
     * Show the Main Dashboard for the Livestream module
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mainDashboard()
    {
        //	    try {
        // @TODO [Josh] - All of this "video loading" needs to be handled on the FRONT-END, NOT HERE because it slows down the loading process
//        $streamService = new StreamService($this->_livestreamAccount);
//        $Livestreams = $streamService->getLivestreams();
        //	    } catch (Exception $e) {
        //		    $isLivestreaming = false;
        //		    $Livestreams = null;
        //	    }
//
//        if (!empty($Livestreams)) {
//            $isLivestreaming = true;
//            $videos = $Livestreams; // @TODO [Josh] - need to check for livestream, if no livestreams, then input the most recent video
//        } else {
        $isLivestreaming = false;
        $mostRecentVideo = $this->_livestreamAccount->mostRecentVideo();
        if (! empty($mostRecentVideo)) {
            $videos = collect([$mostRecentVideo]);
        }
//        }
        $recentVideoPlaylist = '';
//        if (!empty($videos)) {
//            $recentVideoPlaylist = $this->_playerService->formatForJWPlayerPlaylist($videos);
//        }
        $LivestreamAccountId = $this->_livestreamAccount->id;
        $episodeTemplate = $this->_livestreamAccount->default_episode_template;

        $plan_type = 'free';
        //	    $plan_type = Auth::user()->sparkPlan('free');

        return view('livestream::dashboard/index', compact('LivestreamAccountId', 'recentVideoPlaylist', 'episodeTemplate', 'isLivestreaming', 'plan_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created Dashboard in storage.
     *
     * @param  DashboardRequest|Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DashboardRequest $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        return view('livestream::dashboard/index', compact('dashboard'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        return view('livestream::dashboard/edit', compact('dashboard'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DashboardRequest|Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(DashboardRequest $request, Dashboard $dashboard)
    {
        return view('livestream::dashboard/update', compact('dashboard'));
    }

    /**
     * Remove the Dashboard and associated files from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return view('livestream::dashboard/index', compact('dashboard'));
    }
}
