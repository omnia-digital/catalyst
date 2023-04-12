<?php

namespace Modules\Livestream\Exceptions;

class UnsupportedBroswerException extends OmniaRuntimeException
{
    /**
     * UnsupportedBroswerException constructor.
     *
     * @param  string  $message
     * @param  int  $code
     */
    public function __construct($message = '', Collection $context = null, $code = 0, Exception $previous = null)
    {
        $message = 'Unsupported Browser: ' . $message;

        return parent::__construct($message, $context, $code, $previous);
    }
}
