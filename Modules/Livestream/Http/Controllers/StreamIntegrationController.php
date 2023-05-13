<?php

namespace Modules\Livestream\Http\Controllers;

use Exception;
use GuzzleHttp\Psr7\Stream;
use Modules\Livestream\Http\Requests\StreamIntegrationRequest;
use Modules\Livestream\StreamIntegration;

/**
 * Class StreamIntegrationController
 */
class StreamIntegrationController extends LivestreamController
{
    /**
     * Return all current Stream Integratiosn for given or current livestreamAccont
     * (*a user cannot have a stream integration at this time*)
     *
     * @param  null  $team_id
     * @return \Illuminate\Http\Response
     */
    public function index($livestreamAccount = null)
    {
        if (is_null($livestreamAccount)) {
            $livestreamAccount = $this->_livestreamAccount;
        }
        $results = StreamIntegration::where('livestream_account_id', $livestreamAccount->id)->get();

        return $results;
    }

    public function getPossibleStreamIntegrations()
    {
        return [
            'facebook',
            //			'youtube'
        ];
    }

    /**
     * Show the form for creating a new streamIntegration.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created StreamIntegration in storage.
     *
     *
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(StreamIntegrationRequest $request)
    {
        $streamIntegration = StreamIntegration::where('livestream_account_id', '=', $request->livestream_account_id)->where('provider', '=', $request->provider)->get();
        // need to check if this stream integration already exists
        if (! empty($streamIntegration) && $streamIntegration->isNotEmpty()) {
            return $this->update($request, $streamIntegration->first()->id);
        } else {
            $request = $request->all();
            foreach ($request as $key => $value) {
                if (empty($value)) {
                    unset($request[$key]);
                }
            }
            $streamIntegration = StreamIntegration::create($request);

            return $streamIntegration;
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function update(StreamIntegrationRequest $request, $id)
    {
        try {
            $streamIntegration = StreamIntegration::findOrFail($id);
            $request = $request->all();
            if (empty($request['episode_template_id'])) {
                $request['episode_template_id'] = null;
            }

            return response()->json([
                'success' => $streamIntegration->update($request),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the LivestreamAccount and associated files from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function destroy($id)
    {
    }
}
