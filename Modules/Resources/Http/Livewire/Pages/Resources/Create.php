<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Phuclh\MediaManager\WithMediaManager;
use Spatie\Tags\Tag;

class Create extends Component
{
    use WithMediaManager;

    public ?string $body = null;

    public ?string $url = null;

    // Add Resource tag to all resources
    /**
     * @psalm-param list<mixed> $tags
     */
    public function addResourceTag(array $tags) : array
    {
        if (!array_key_exists('resource', $tags)) {
            $tags[] = 'resource';
        }

        return $tags;
    }

    /**
     * @return string[]
     *
     * @psalm-return list<string>
     */
    public function pullTags($text): array
    {
        $regexForHashtags = "/\B#([a-z0-9_-]+)/i";
        $hashtags = array();

        preg_match_all($regexForHashtags, $text, $hashtags);

        return $hashtags[1];
    }

    /**
     * @psalm-return list<mixed>
     * @param string[] $hashtags
     *
     * @psalm-param list<string> $hashtags
     */
    public function getTags(array $hashtags): array
    {
        $tags = array();

        foreach ($hashtags as $hashtag) {
            $tags[] = Tag::findOrCreateFromString($hashtag);
        }

        return $tags;
    }
}
