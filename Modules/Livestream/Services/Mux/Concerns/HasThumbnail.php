<?php

namespace Modules\Livestream\Services\Mux\Concerns;

trait HasThumbnail
{
    public function getMuxThumbnail(string $playBackId): string
    {
        return 'https://image.mux.com/' . $playBackId . '/thumbnail.png?width=314&height=178&fit_mode=pad';
    }
}
