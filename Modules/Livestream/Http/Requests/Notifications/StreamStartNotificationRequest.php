<?php

namespace App\Http\Requests\Notifications;

use App\Http\Requests\Notifications\WowzaNotificationRequest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class StreamStartNotificationRequest extends WowzaNotificationRequest
{


    public function __construct(Request $request)
    {
	    Log::info('Stream Started');
        $request = $request->all();
	    foreach($request as $key => $value) {
		    Log::debug($key . ': ' . $value);
	    }
        $this->streamName = (!empty($request['streamName']) ? $request['streamName'] : '');
        return $request;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }

	/**
	 * Runs all validators
	 *
	 * @return mixed true|string True is success. If error, the message is return as string
	 * @throws \Exception
	 */
	public function validateAll()
	{
		// These should all be true. If false, throw an error
		$attributes['Trans Video'] = !$this->isTranscodedVideo();

		$failedAttributes = collect();
		// If any of these returned false, kick back on that one
		foreach ($attributes as $rule => $attribute) {
			if ($attribute !== true) {
				$failedAttributes->push($rule);
			}
		}
		if ($failedAttributes->isNotEmpty()) {
			$response = new Response();
			$msgCollection = collect();
			$msgCollection->put('failures',$failedAttributes);
			( !empty($failedAttributes) ? $msgCollection->prepend($this->streamName,'object') : null );

			$response->setContent($msgCollection);
			throw new ValidationException($this->getValidatorInstance(),$response);
		}
		return true;
	}

	/**
	 * Check if Video is a transcoded Video file
	 *
	 * @return bool
	 */
	public function isTranscodedVideo()
	{
		// Check if its a Transcoded video. We only want the original source video
		return strpos($this->streamName, '_trans_') === false ? false : true;
	}
}
