<?php

namespace Modules\Feeds\Services;

use App\Support\Feed\FeedItem;
use Illuminate\Encryption\Encrypter;

class FeedManager
{
    public function __construct(
        protected Encrypter $encrypter,
    ) {
    }

    public function encryptFeedPayload(FeedItem $feedItem): string
    {
        return $this->encrypter->encrypt(gzcompress(serialize([
            'url' => $feedItem->get_permalink(),
            'content' => $feedItem->get_description(),
        ])));
    }

    public function decryptFeedPayload(string $url): array
    {
        $payload = $this->encrypter->decrypt($url);

        return unserialize(gzuncompress($payload));
    }

    public function uniqueFeedId(string $url): string
    {
        return md5($url);
    }
}
