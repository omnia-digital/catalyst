<?php

namespace Modules\Livestream\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChannelNotFoundException extends NotFoundHttpException
{
    protected $message = 'Could not find that Channel. Please check to make sure the url you entered is correct';
}
