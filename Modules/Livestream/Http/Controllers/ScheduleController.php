<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\EnvironmentDetector;
use App\EpisodeTemplate;
use App\Http\Requests\ScheduleRequest;
use App\LivestreamAccount;
use App\Schedule;
use App\Http\Requests;
use App\Http\Controllers\LivestreamController;
use App\WowzaMediaServer;
use App\WowzaVhost;
use App\WowzaPublisher;
use App\WowzaVhostHostPort;
use App\Services\StreamService;


class ScheduleController extends LivestreamController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $start_date = new Carbon();
        $end_date = new Carbon();
        $start_date->setTimezone($this->_livestreamAccount->team->timezone);
        $end_date->setTimezone($this->_livestreamAccount->team->timezone);

        return $schedules = $this->_livestreamAccount->schedules;

//        $episode_template = EpisodeTemplate::create([
//            'template' => '',
//            'livestream_account_id' => $this->_livestreamAccount->id
//        ]);
//
//        $schedule = Schedule::create([
//            'start_date' => $start_date,
//            'end_date'  => $end_date->addHours(2),
//            'recurrence_type' => 'biWeekly',
//            'livestream_account_id' => 1,
//            'episode_template_id' => 1
//        ]);
//        $schedule->checkDateTime();
        return view('livestream::schedule/index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $availableHours = ['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'];
        $availableMinutes = ['00'=>'00','15'=>'15','30'=>'30','45'=>'45'];
        $LivestreamAccount = $this->_livestreamAccount;

        return view('livestream::schedule/create', compact('availableHours','availableMinutes','LivestreamAccount'));
    }

    /**
     * Store a newly created Schedule in storage.
     *
     * @param ScheduleRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {
        $request = $request->all();
        $request['livestream_account_id'] = $this->_livestreamAccount->id;

        $start_date = Carbon::createFromFormat('Y-m-d',$request['start_date']);
        $start_date->setTimeFromTimeString($request['start_time_hour'] . ":" . $request['start_time_min']);
        $request['start_date'] = $start_date;

        $end_date = Carbon::createFromFormat('Y-m-d',$request['end_date']);
        $end_date->setTimeFromTimeString($request['end_time_hour'] . ":" . $request['end_time_min']);
        $request['end_date'] = $end_date;

        $schedule = Schedule::create($request);

        return redirect(route('livestream::schedule.edit',[$schedule->id]));

    }

    /**
     * Display the specified resource.
     *
     * @param Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        return $this->edit($schedule);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        $availableHours = ['01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12'];
        $availableMinutes = ['00'=>'00','15'=>'15','30'=>'30','45'=>'45'];
        return view('livestream::schedule.edit', compact('schedule','availableHours','availableMinutes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ScheduleRequest $request
     * @param Schedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $request = $request->all();

        $start_date = Carbon::createFromFormat('Y-m-d',$request['start_date']);
        $start_date->setTimeFromTimeString($request['start_time_hour'] . ":" . $request['start_time_min']);
        $request['start_date'] = $start_date;

        $end_date = Carbon::createFromFormat('Y-m-d',$request['end_date']);
        $end_date->setTimeFromTimeString($request['end_time_hour'] . ":" . $request['end_time_min']);
        $request['end_date'] = $end_date;

        $schedule->update($request);

        return \Redirect::back()->with(['flash.message' => 'Save Successful!','flash.level' => 'success']);
    }

    /**
     * Remove the LivestreamAccount and associated files from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        Schedule::destroy($schedule->id);
        return redirect('/livestream');
        // @TODO [Josh] - set it up so it soft deletes and can be recovered within 30 days
    }

}
