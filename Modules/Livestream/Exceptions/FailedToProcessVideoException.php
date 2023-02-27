<?php

namespace Modules\Livestream\Exceptions;

use Illuminate\Support\Collection;

class FailedToProcessVideoException extends LivestreamRuntimeException
{
	public function __construct($message = "", Collection $context = null, $code = 0, Exception $previous = null)
	{
		$message = 'Video could not be processed: ' . $message;
		return parent::__construct($message, $context, $code, $previous);
	}
}
