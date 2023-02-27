<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Event;
use App\LivestreamAccount;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\LivestreamController;
use App\WowzaMediaServer;
use App\WowzaVhost;
use App\WowzaPublisher;
use App\WowzaVhostHostPort;

class EventController extends LivestreamController
{

    /**
     * Create a AccountController Instance
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
//        $account = Auth::user()->LivestreamAccount;
        return view('livestream::event/dashboard');
//            ->with('account', $account);
    }

    /**
     * Show the form for creating a new Event.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $LivestreamAccounts = Auth::user()->LivestreamAccounts;

//        foreach ($LivestreamAccounts as $LivestreamAccount) {
//            $items = $LivestreamAccount->LivestreamApplications;
//        }
        $LivestreamAccounts = $LivestreamAccounts->lists('account_name','id');
//        $LivestreamApplications = collect($items)->lists('title', 'id');
        return view('livestream::event/create', compact('LivestreamAccounts', 'LivestreamApplications'));
    }

    /**
     * Store a newly created Account in storage.
     *
     * @param EventRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequest $request)
    {
        // @TODO [Josh] - this whole process needs to be queued so user doesn't have to wait.
        // @TODO [Josh] - also, we need to add timers to it so we know how long it takes
        // Can only get this far if user is logged in and has module_active_liveevent = 'Y'


        // @TODO [Josh] - Need to get a Wowza media server check if it has a certain amount of accounts on it
        //  if it is under the account_limit,
        // then add to that wowza server
        // ##Eventually this will find the first server
        // that has # of vhosts less than vhost limit##
//        $server = WowzaMediaServer::find(1);
//        $accountSlug = $user->account->account_slug;
//        $appType = $request->stream_type;
//        $LivestreamSlug = substr(strtolower(str_replace(' ', '_', $request->livestream_title)), 0, 10);
//        $app_slug = $user->account->account_slug .'_'. $appType;

        // @TODO [Josh] - need to add check to see if this account has purchased a package that allows them to have another LivestreamAccount

        $user = Auth::user();
        $wowzaMediaServer = WowzaMediaServer::find(1);
        $request = $request->all();
        $title = ucwords($request['event_title']);
        $eventType = $request['event_type'];
        $timezone = $request['timezone'];
        $Livestream_account = LivestreamAccount::find($request['livestream_account']);

        // If its the same as the generic account, then we don't want to overide it.
        if ( $user->account->timezone === $timezone ) {
            $timezone = null;
        }

        $slugify = new Slugify();
        $liveApp = $Livestream_account->LivestreamApplications->where('app_type', 'live')->first();

        // Omnia Events === WowzaAppInstances
        // This is creating the Event in the database only
        // so we can display it to the user when we show them the links to put in the media encoder
        // @TODO [Josh] - We need to somehow check if the AppInstance is running when they are streaming
        // (eg. sunday_service)
        $event = Event::create([
            'title' => $title,
            'description' => 'description of the event',
            'event_type' => $eventType,
            'timezone' => '',
            'event_slug' => $slugify->slugify($title, '_'),
            'recurring_f' => 'N',
            'recurring_statement' => '',
            'livestream_account_id' => $Livestream_account->id,
            'livestream_app_id' => $liveApp->id,
        ]);

        //            'recurring_day' => $request['recurring_day'],


        /** LEGEND **/
        // Omnia Account + StreamType === Wowza Application
            // (eg. desertreign_live)
        // Omnia Events === WowzaAppInstances
            // (eg. sunday_service)
        // Omnia Episodes === Wowza Streams
            // (eg. 11152015-1)
        // rtmp://wowzahost/<appname>/<appinstance>/myStream

        flash()->overlay('You created your first Live Streaming Event!', 'Great Job!');

        return redirect()->route('livestream::dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  Account  $account
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        return view('livestream::event/profile', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Account  $Account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        $groups = Event::lists('name', 'id');

        return view('livestream::event/edit', compact('account', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AccountRequest|Request $request
     * @param  Account               $Account
     *
     * @return \Illuminate\Http\Response
     */
    public function update(AccountRequest $request, Account $Account)
    {
        $Account->update($request->all());

        $Account->groups()->sync($request->input('group_list'));

        return redirect('livestream::event');
    }

    /**
     * Remove the LivestreamAccount and associated files from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // need to move entire vhost directory to the "needs to be deleted" folder, where it will expire and be deleted after 30 days
        // need to delete VHost record from /usr/local/wowza/conf/VHosts.xml
        $count = Account::destroy($id);

        flash('People deleted: ' . $count);

        return redirect('event');
    }

    /**
     * Save a new Account
     *
     * @param AccountRequest $request
     *
     * @return static
     */
    private function _createAccount(AccountRequest $request)
    {

    }

}
