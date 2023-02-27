<?php namespace App\Enums;

class EpisodeDownloadStatus
{
    const PENDING = 'pending';
    const DOWNLOADING = 'downloading';
    const ZIPPING = 'zipping';
    const READY = 'ready';
    const FAILED = 'failed';
    const EXPIRED = 'expired';
}
