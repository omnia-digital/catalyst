<?php

    namespace Modules\Livestream\Http\Controllers;

    use Modules\Livestream\Omnia;
    use Exception;
    use Illuminate\Support\Facades\Auth;
    use Modules\Livestream\Http\Requests\StreamTargetRequest;
    use Modules\Livestream\Repositories\StreamTargetRepository;
    use Modules\Livestream\Stream;
    use Modules\Livestream\StreamTarget;

    /**
     * Class StreamTargetController
     * For non-mux customers, we will continue to use StreamIntegrations the way we always have.
     * However, for Mux customers, we will continue to use StreamIntegrations as an Account-Level integration with FB, YT, etc. to hold the access_keys
     * We will then use Stream Targets as a 1-to-1 object identifier of Simulcast Targets on Mux
     *
     * @package App\Http\Controllers
     */
    class StreamTargetController extends LivestreamController
    {
        /**
         * Return all current Stream Targets for given or current livestreamAccont
         * (*a user cannot have a stream integration at this time*)
         *
         * @return \Illuminate\Http\Response
         */
        public function index($livestreamAccount = null)
        {
            if (is_null($livestreamAccount)) {
                $livestreamAccount = $this->_livestreamAccount;
            }
            $defaultStream = $livestreamAccount->defaultStream;
            return $defaultStream->streamTargets;
        }

        /**
         * Store a newly created StreamTarget in storage.
         *
         * @param StreamTargetRequest $request
         *
         * @return mixed
         * @throws Exception
         */
        public function store(StreamTargetRequest $request)
        {
            // @TODO [Josh] - check if this account can add another stream target
            // dependent on livestream plan and check an exception list for accounts that are allowed to add more
            $accountCanAddAnotherStreamTarget = true;

            if (!$accountCanAddAnotherStreamTarget) {
                return response([
                    'message' => 'This account cannot add another Stream Target'
                ], 403);
            }

            // Get Stream
            if ($request->has('stream_id')) {
                $stream_id = $request->get('stream_id');
                $stream    = Stream::findOrFail($stream_id);
            } else if (Auth::check()) {
                $currentTeam = Auth::user()->currentTeam();
                if ( ! empty($currentTeam) && !empty($currentTeam->livestreamAccount)) {
                    $stream = $currentTeam->livestreamAccount->default_stream;
                }
            }
            if (empty($stream)) {
                return response([
                    'message' => 'Could not find Stream. Please make sure you have created one.'
                ], 404);
            }

            // Params
            $params['name'] = $request->get('name');
            $params['url'] = $request->get('url');
            $params['stream_key'] = $request->get('stream_key');
            $params['passthrough'] = $request->get('passthrough');
            $params['stream'] = $stream;

            // Create Stream Target
            $streamTarget = Omnia::interact(StreamTargetRepository::class . '@create', [$params]);

            return $streamTarget;

        }

        /**
         * Display the specified resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            return StreamTarget::findOrFail($id);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param StreamTargetRequest $request
         *
         * @return \Illuminate\Http\Response
         */
        public function update(StreamTargetRequest $request, StreamTarget $stream_target)
        {
            try {
                return response()->json([
                    'success' => Omnia::interact(StreamTargetRepository::class . '@update', [$stream_target, $request])
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'errors' => $e->getMessage()
                ]);
            }
        }

        /**
         * Destroy the resource
         *
         * @param int $ids
         *
         * @return \Illuminate\Http\Response
         * @throws Exception
         */
        public function destroy($ids)
        {
            try {
                return response()->json(Omnia::interact(StreamTargetRepository::class . '@destroy', [$ids]));
            } catch (Exception $e) {
                return abort($e->getCode(), $e->getMessage());
            }
        }
    }