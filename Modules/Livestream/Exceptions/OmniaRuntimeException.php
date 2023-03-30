<?php

namespace Modules\Livestream\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Collection;

class OmniaRuntimeException extends HttpResponseException
{
    public function __construct($message = '', Collection $context = null, $code = 500, Exception $previous = null)
    {
        if (! empty($context) && $context->isNotEmpty()) {
            $contextJson = json_encode($context);
            $message .= ' Context: ' . $contextJson;
        }

        $response = response()->json(['message' => $message], $code);

        return parent::__construct($response);
    }
}
