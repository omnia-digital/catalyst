<?php

namespace Modules\Livestream\Exceptions;

use Modules\Livestream\Exceptions\OmniaRuntimeException;
use Illuminate\Support\Collection;

class LivestreamRuntimeException extends OmniaRuntimeException
{
	public function __construct($message = "", Collection $context = null, $code = 500, Exception $previous = null)
	{
		$message = 'Livestream Error: ' . $message;
		return parent::__construct($message, $context, $code, $previous);
	}
}
