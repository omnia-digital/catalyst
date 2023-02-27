<?php namespace App\Registries\VideoSource\Concerns;

use App\Models\Video;

interface BaseVideoSource
{
    public function name(): string;

    public function asSourceVideo();

    public function playbackUrl(Video $video): ?string;

    public function downloadUrl(Video $video): ?string;

    public function delete(Video $video): void;

    public function isProcessing(Video $video): bool;
}
