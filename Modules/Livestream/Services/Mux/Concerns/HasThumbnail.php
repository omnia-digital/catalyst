<?php namespace App\Services\Mux\Concerns;

trait HasThumbnail
{
    /**
     * @param string $playBackId
     * @return string
     */
    public function getMuxThumbnail(string $playBackId): string
    {
        return 'https://image.mux.com/' . $playBackId . '/thumbnail.png?width=314&height=178&fit_mode=pad';
    }
}
