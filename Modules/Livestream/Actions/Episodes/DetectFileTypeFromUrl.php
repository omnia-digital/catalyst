<?php

namespace App\Actions\Episodes;

class DetectFileTypeFromUrl
{
    public function execute(string $url): string
    {
        $ext = pathinfo($url, PATHINFO_EXTENSION);

        return empty($ext) ? 'mp4' : $ext;
    }
}
