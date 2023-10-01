<?php

namespace Modules\Livestream\Actions\Episodes;

use Carbon\Carbon;
use Exception;
use Modules\Livestream\Jobs\Episode\ImportEpisodeItemFromRssJob;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Models\Person;
use SimplePie_Item;
use SimpleXMLElement;

class ImportEpisodesFromRssAction
{
    public function execute(
        string $rssUrl,
        int|null|LivestreamAccount $livestreamAccount = null,
        bool $checkDuplicate = true
    ): int {
        $livestreamAccount = $this->resolveLivestreamAccount($livestreamAccount);

        $rssItems = simplexml_load_file($rssUrl)->channel->item;

        $jobsCount = 0;

        /** @var SimplePie_Item $item */
        foreach ($rssItems as $item) {
            $episodeData = $this->prepareEpisodeData($item);

            // Don't save episode has the wrong record date.
            if ($episodeData['date_recorded']->toDateTimeString() === '1970-01-01 00:00:00') {
                continue;
            }

            $episode = $this->findEpisode($episodeData);

            // Check duplicate by episode title and record date.
            if ($checkDuplicate && $this->checkDuplicate($episode)) {
                continue;
            }

            $jobsCount++;

            dispatch(new ImportEpisodeItemFromRssJob($episodeData, $livestreamAccount, $episode));
        }

        return $jobsCount;
    }

    private function resolveLivestreamAccount(int|null|LivestreamAccount $livestreamAccount): LivestreamAccount
    {
        if ($livestreamAccount instanceof LivestreamAccount) {
            return $livestreamAccount;
        }

        if (is_null($livestreamAccount)) {
            return auth()->user()->currentTeam->livestreamAccount;
        }

        if (! ($livestreamAccount = LivestreamAccount::find($livestreamAccount))) {
            throw new Exception('Cannot find the livestream account');
        }

        return $livestreamAccount;
    }

    private function prepareEpisodeData(SimpleXMLElement $item): array
    {
        return [
            'title' => (string) $item->title,
            'date_recorded' => Carbon::parse((string) $item->pubDate),
            'description' => (string) $item->description,
            'main_passage' => (string) $item->passage,
            'main_speaker_id' => (string) $this->findSpeaker($item)?->id,
            'media_url' => (string) $item->guid,
            'attachments' => $this->getAttachments($item),
            'series' => (string) $item->series,
            'category' => (string) $item->category,
        ];
    }

    private function findSpeaker(SimpleXMLElement $item): ?Person
    {
        $itunes = $item->children('http://www.itunes.com/dtds/podcast-1.0.dtd');

        $author = explode(' ', (string) $itunes->author);
        $firstName = $author[0];
        $lastName = $author[1] ?? $firstName;

        return Person::firstOrCreate([
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);
    }

    private function getAttachments(SimpleXMLElement $item): array
    {
        $attachments = (array) $item->attachments->attachment;
        unset($attachments[0]);

        return $attachments;
    }

    private function findEpisode(array $episodeData): ?Episode
    {
        return Episode::query()
            ->where('title', $episodeData['title'])
            ->where('date_recorded', $episodeData['date_recorded'])
            ->first();
    }

    private function checkDuplicate(?Episode $episode): bool
    {
        if (! $episode) {
            return false;
        }

        return $episode->video()->exists();
    }
}
