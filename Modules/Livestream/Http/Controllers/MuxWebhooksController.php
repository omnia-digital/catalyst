<?php namespace App\Http\Controllers;

use App\Events\StreamActive;
use App\Events\StreamCompleted;
use App\Events\StreamDeleted;
use App\Events\StreamIdle;
use App\Events\StreamUpdated;
use App\Events\VideoAssetReady;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MuxWebhooksController extends Controller
{
    public function __invoke(Request $request)
    {
        if (config('services.mux.signing_secret') && !$this->verifySignature($request)) {
            abort(401, 'Signature Invalid');
        }

        if (!($event = $request->get('type'))) {
            return;
        }

        $payload = $request->all();

        match ($event) {
            'video.asset.ready' => event(new VideoAssetReady($payload)),
            'video.live_stream.active' => event(new StreamActive($payload)),
            'video.live_stream.idle' => event(new StreamIdle($payload)),
            'video.live_stream.updated' => event(new StreamUpdated($payload)),
            'video.live_stream.deleted' => event(new StreamDeleted($payload)),
            'video.asset.live_stream_completed' => event(new StreamCompleted($payload)),
            default => $this->noHandler($event)
        };
    }

    /**
     * Verify the signature.
     *
     * @param Request $request
     * @return boolean
     */
    protected function verifySignature(Request $request)
    {
        // Get the signature from the request header
        $muxSig = $request->header('Mux-Signature');

        if (empty($muxSig)) {
            return false;
        }

        // Split the signature based on ','.
        // Format is 't=[timestamp],v1=[hash]'
        $muxSigArray = explode(',', $muxSig);

        if (empty($muxSigArray) || empty($muxSigArray[0]) || empty($muxSigArray[1])) {
            return false;
        }

        // Strip the first occurrence of 't=' and 'v1=' from both strings
        $muxTimestamp = Str::replaceFirst('t=', '', $muxSigArray[0]);
        $muxHash = Str::replaceFirst('v1=', '', $muxSigArray[1]);

        // Create a payload of the timestamp from the Mux signature and the request body with a '.' in-between
        $payload = $muxTimestamp . "." . $request->getContent();

        // Build a HMAC hash using SHA256 algo, using our webhook secret
        $ourSignature = hash_hmac('sha256', $payload, config('services.mux.signing_secret'));

        // `hash_equals` performs a timing-safe crypto comparison
        return hash_equals($ourSignature, $muxHash);
    }

    private function noHandler($event)
    {
        Log::debug('Cannot find handler for Mux Event: ' . $event);

        return null;
    }
}
