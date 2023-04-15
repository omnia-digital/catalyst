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
            'title' => $feedItem->get_title(),
            'published_at' => $feedItem->get_date(),
            'author' => $feedItem->get_author(),
            'content' => $feedItem->get_description(),
            'imageUrl' => $this->getDefaultItemImage($feedItem),
        ])));
    }

    public function getDefaultItemImage($item)
    {
        $image = ($item->get_media() && $item->get_media()['url']) ? $item->get_media()['url'] : null;
        if (empty($image)) {
            $image = ($item->get_thumbnail() && $item->get_thumbnail()['url']) ? $item->get_thumbnail()['url'] : null;
            if (empty($image)) {
                $image = $this->searchForImageInContent($item->get_content());
                if (! empty($image)) {
                    return $image;
                }
            }
        }

        return $image ?? null;
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
