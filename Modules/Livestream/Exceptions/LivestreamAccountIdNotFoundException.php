<?php

namespace App\Exceptions;

use App\Exceptions\MissingParameterException;
use Illuminate\Support\Collection;

class LivestreamAccountIdNotFoundException extends MissingParameterException
{
	public function __construct($message = "", Collection $context = null, $code = 422, Exception $previous = null)
	{
		$defaultMsg = 'Livestream Account could not be found.';
		if (empty($message)) {
            $message = $defaultMsg;
        } else {
            $message = $defaultMsg . ': ' . $message;
        }

		return parent::__construct("livestream_account_id", $message, $context, $code, $previous);
	}
}
