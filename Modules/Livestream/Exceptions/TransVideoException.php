<?php

namespace App\Exceptions;

use Illuminate\Support\Collection;

class TransVideoException extends VideoProcessingNotNeededException
{
	public function __construct($message = "", Collection $context = null, $code = 0, Exception $previous = null)
	{
		$message = 'Video is a trans video: ' . $message;
		return parent::__construct($message, $context, $code, $previous);
	}
}
