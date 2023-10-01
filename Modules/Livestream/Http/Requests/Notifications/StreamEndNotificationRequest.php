<?php

namespace Modules\Livestream\Http\Requests\Notifications;

use Exception;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Modules\Livestream\Http\Requests\Notifications\Aws\VideoS3SNSNotificationRequest;

class StreamEndNotificationRequest extends VideoS3SNSNotificationRequest
{
    /**
     * Runs all validators
     *
     * @return mixed true|string True is success. If error, the message is return as string
     *
     * @throws Exception
     */
    public function validateAll($correctTopic, FilesystemAdapter $storage)
    {
        // These should all be true. If false, throw an error
//            $attributes['Incorrect Topic'] = $this->isCorrectTopic($correctTopic);
        $attributes['File Doesn\'t Exist'] = $this->checkIfFileExistsOn($storage);
        $attributes['Trans Video'] = !$this->isTranscodedVideo();
        $attributes['Video Empty'] = !$this->isVideoEmpty();

        $failedAttributes = collect();
        // If any of these returned false, kick back on that one
        foreach ($attributes as $rule => $attribute) {
            if ($attribute !== true) {
                $failedAttributes->push($rule);
            }
        }
        if (!$failedAttributes->isEmpty()) {
            $response = new Response;
            $msgCollection = collect();
            $msgCollection->put('failures', $failedAttributes);
            (!empty($failedAttributes) ? $msgCollection->prepend($this->fullFilePath, 'object') : null);

            $response->setContent($msgCollection);
            throw new ValidationException($this->getValidatorInstance(), $response);
        }

        return true;
    }

    /**
     * Check if File Exists on given Storage
     *
     * @return bool
     */
    public function checkIfFileExistsOn(FilesystemAdapter $storage)
    {
        return $storage->exists($this->fullFilePath);
    }

    /**
     * Check if Video is a transcoded Video file
     *
     * @return bool
     */
    public function isTranscodedVideo()
    {
        // Check if its a Transcoded video. We only want the original source video
        return strpos($this->fullFilePath, '_trans_') === false ? false : true;
    }

    /**
     * Check if Video size is empty
     *
     * @return bool
     */
    public function isVideoEmpty()
    {
        // Check if Video File is empty
        return $this->videoObject['size'] <= 0 ? true : false;
    }
}
