<?php

namespace Modules\Livestream\Traits;

trait FormatsBytes
{
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param int $size
     * @param int $precision
     * @return int
     */
    public static function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int)$size;
            $base = log($size) / log(1024);
            $suffixes = [' bytes', ' KB', ' MB', ' GB', ' TB'];

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }

    /**
     * Convert Bytes to GB
     *
     * @return string
     */
    public static function bytesToGB($bytes)
    {
        return round($bytes / 1024 / 1024 / 1024, 2);
    }
}
