<?php

namespace Modules\Livestream\Http\Requests\Notifications\Aws;

use Modules\Livestream\Http\Requests\Notifications\Aws\S3SNSNotificationRequest;
use Auth;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VideoS3SNSNotificationRequest extends S3SNSNotificationRequest
{
    public $videoObject;
    public $fullFilePath;
    public $storage;
	public $LivestreamAccountId;

	/**
	 * VideoS3SNSNotificationRequest constructor.
	 *
	 * @param Request $request
	 *
	 * @throws \Exception
	 */
    public function __construct(Request $request)
    {
        $request = parent::__construct($request);
        if (!empty($this->notification)) {
            $message = json_decode($this->notification['Message'],true);
            $records = (!empty($message['Records']) ? $message['Records'] : null);
            $firstRecord = (!empty($records[0]) ? $records[0] : null);
            $s3 = (!empty($firstRecord) ? $firstRecord['s3']: null);
            if (empty($s3)) {
                Log::info($this->notification);
                throw new \Exception('Incorrect Structure/Format for this Notification Request. Could not find correct "s3" section to parse video object: ' . $this->notification['Message']);
            } else {
                $videoObject = $s3['object'];
                $this->videoObject = $videoObject;
                $this->fullFilePath = $videoObject['key'];
	            $matches = [];
	            preg_match('/.+?(?=\/)/',$videoObject['key'],$matches);
	            $this->LivestreamAccountId = ( !empty($matches[0]) ? $matches[0] : null); // should only be one match, so we are only grabbing the first one
	            $request->merge([
                    'videoObject' => $this->videoObject,
                    'fullFilePath' => $this->fullFilePath,
		            'LivestreamAccountId' => $this->LivestreamAccountId
                ]);
            }
        }
        return $request;
    }

}
