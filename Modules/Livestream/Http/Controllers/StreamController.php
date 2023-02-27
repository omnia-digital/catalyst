<?php

    namespace App\Http\Controllers;


    use App\Omnia;
    use Illuminate\Http\Request;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Requests\LivestreamRequest;
    use App\LivestreamAccount;
    use App\Player;
    use App\Repositories\StreamRepository;
    use App\Services\MuxService;
    use App\Services\StreamService;
    use App\Stream;
    use Livestream\Livestream;

    class StreamController extends LivestreamController
    {
        /**
         * The Stream Service that is used throughout this class
         *
         * @var StreamService
         */
        private $_streamService;

        public function __construct(Request $request, StreamService $streamService)
        {
            parent::__construct($request);
            $params = $request->all();
            if (( ! empty($params['account']) || ! empty($params['livestreamAccount'])) && ! empty($params['player'])) {
                $streamType = ! empty($params['streamType']) ? $params['streamType'] : null;
                if ( ! empty($params['livestreamAccount'])) {
                    $this->_livestreamAccount = LivestreamAccount::findOrFail($params['livestreamAccount']);
                } else if ( ! empty($params['account'])) {
                    $this->_livestreamAccount = LivestreamAccount::findOrFail($params['account']); // @NOTE - keeping this for now for backwards compatibility
                }
                $this->_streamService = new StreamService($this->_livestreamAccount, Player::findOrFail($params['player']), $streamType);
            } else {
                $this->_streamService = $streamService;
            }
        }

        /**
         * List Streams
         *
         * @param LivestreamRequest $request
         *
         * @return Collection streams
         */
        public function index(LivestreamRequest $request)
        {
            // if we pass in a livestream_account, list those streams, otherwise list for user
            if ($request->has('livestream_account_id')) {
                $livestream_account_id = $request->get('livestream_account_id');
                $livestream_account    = LivestreamAccount::findOrFail($livestream_account_id);
            } else {
                $user               = Auth::user();
                $livestream_account = $user->currentTeam->livestreamAccount;
            }
            $streams = $livestream_account->streams;

            return $streams;
        }

        /**
         * Test Endpoint to create streams
         */
        public function createStream()
        {
            $user               = Auth::user();
            $livestream_account = $user->currentTeam->livestreamAccount;
            $stream             = Omnia::interact(StreamRepository::class . '@create', [$livestream_account]);
        }

        /**
         * Create new Stream
         *
         * @param LivestreamRequest $request
         *
         * @return Stream
         */
        public function store(LivestreamRequest $request)
        {
            $stream = StreamRepository::create($request->all());

            return $stream;
        }

        /**
         * Update a stream
         *
         * @param LivestreamRequest $request
         * @param Stream            $stream
         *
         * @return Stream
         */
        public function update(LivestreamRequest $request, Stream $stream)
        {
            $stream->update($request->all());

            return $stream;
        }

        /**
         * Destroy streams by id(s)
         *
         * @param LivestreamRequest $request
         * @param Stream            $stream
         *
         * @return \Illuminate\Http\JsonResponse success on destroy
         */
        public function destroy(LivestreamRequest $request, $ids)
        {
            $success = Stream::destroy($ids);

            return response()->json(['success' => $success]);
        }

        /**
         * @param Request $request
         *
         * @return array
         * @throws \Exception
         */
        public function getLivestreams(Request $request)
        {
            return $this->_streamService->getLivestreams();
        }

        /**
         * @param Request $request
         *
         * @return array|string
         * @throws \Exception
         */
        public function getDVRLivestreams(Request $request)
        {
            return $this->_streamService->getDVRLivestreams($request);
        }

        /**
         * Return whether or not a given LivestreamAccount is Currently Streaming
         *
         * @param Request           $request
         * @param LivestreamAccount $livestreamAccount
         *
         * @return mixed
         * @throws \Exception
         */
        public function isCurrentlyStreaming(Request $request, LivestreamAccount $livestreamAccount)
        {
            return response()->json($livestreamAccount->is_live_now);
        }

        /**
         * Get the current livestream for given livestream account (or logged in one)
         *
         * @param Request $request
         *
         * @return \Illuminate\Http\JsonResponse | false   Collection Object with
         * @throws \Exception
         */
        public function getCurrentLivestreamForAccount(Request $request, LivestreamAccount $livestreamAccount)
        {
            $response    = false;
            $playbackUrl = '';
            $imageUrl    = '';

            if ( ! empty($livestreamAccount->id)) {
                $this->_livestreamAccount = $livestreamAccount;
            }

            // if livestream account is currently streaming
            $this->_streamService = new StreamService($this->_livestreamAccount);
            if ($this->_streamService->isCurrentlyStreaming()) {
                if ($this->_livestreamAccount->mux_livestream_active == true) {
                    // Mux Live stream
                    // @note we are currently just pulling the first stream for this account, eventually we will need to take in which stream the request is looking for
                    $streams = $this->_livestreamAccount->streams;
                    if ( ! empty($streams) && $streams->isNotEmpty()) {
                        $stream      = $streams->first();
                        $playbackUrl = $stream->default_playback_url;
                    }

                } else {
                    // Wowza Live stream
                    $playbackUrl = $this->_streamService->getLivestreamURL();
                }
            }

            if (empty($imageUrl)) {
                $imageUrl = $this->_livestreamAccount->before_live_image;
            }

            if ( ! empty($playbackUrl)) {
                $response = [
                    'playback_url' => $playbackUrl,
                    'image_url'    => $imageUrl
                ];
            }

            return response()->json($response);
        }

        /**
         * Admin stops stream.
         *
         * @throws \Exception
         */
        public function stopStream(Request $request) {
            if (!Omnia::developer($request->user()->email)) abort(403);

            $livestreamAccount = LivestreamAccount::findOrFail($request->livestreamAccount);

            $this->_streamService = new StreamService($livestreamAccount);

            if ($this->_streamService->isCurrentlyStreaming()) {
                $stream = $livestreamAccount->default_stream;

                $muxService = new MuxService();
                $muxService->finishLivestreamRequest($stream->stream_id);

                return response()->json([
                    'success' => true,
                    'stream_id' => $stream->stream_id,
                    'message' => 'Stopped stream successfully.'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'stream_id' => null,
                'message' => 'Stream is not live.'
            ], 422);
        }

        /**
         * Reset stream key.
         *
         * @param Request $request
         * @return mixed
         * @throws \MuxPhp\ApiException
         */
        public function resetStreamKey(Request $request)
        {
            $stream = Stream::where('stream_id', $request->stream_id)->firstOrFail();

            $muxStream = (new MuxService)->getLiveApi();
            $newStreamKey = $muxStream->resetStreamKey($request->stream_id);

            if (!isset($newStreamKey['data']['stream_key'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot get the new stream key.'
                ], 404);
            }

            $stream->update([
                'stream_key' => $newStreamKey['data']['stream_key']
            ]);

            return $newStreamKey['data']['stream_key'];
        }
    }
