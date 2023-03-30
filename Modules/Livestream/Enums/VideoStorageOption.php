<?php namespace Modules\Livestream\Enums;

use JetBrains\PhpStorm\ArrayShape;

class VideoStorageOption
{
    const DELETE_VIDEO = 'delete-video';
    const PAY_VIDEO_STORAGE = 'pay-video-storage';

    #[ArrayShape([self::DELETE_VIDEO => "string", self::PAY_VIDEO_STORAGE => "string"])]
    public static function options(): array
    {
        return [
            self::DELETE_VIDEO      => 'Delete Video',
            self::PAY_VIDEO_STORAGE => 'Pay for Video Storage'
        ];
    }
}
