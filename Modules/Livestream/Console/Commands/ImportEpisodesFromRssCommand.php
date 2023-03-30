<?php

namespace Modules\Livestream\Console\Commands;

use Illuminate\Console\Command;
use Modules\Livestream\Actions\Episodes\ImportEpisodesFromRssAction;

class ImportEpisodesFromRssCommand extends Command
{
    protected $signature = 'episodes:import-from-rss {--url=} {--account=} {--check-duplicate=}';

    protected $description = 'Import episodes from RSS Feed.';

    public function handle()
    {
        $url = $this->option('url');
        $account = $this->option('account');
        $check_duplicate = $this->option('check-duplicate');

        if (empty($url)) {
            do {
                $rssFeedUrl = $this->ask('Enter RSS Feed URL');
            } while (is_null($rssFeedUrl));
        } else {
            $rssFeedUrl = $url;
        }
        if (empty($account)) {
            do {
                $livestreamAccountId = $this->ask('Enter Livestream Account ID');
            } while (is_null($livestreamAccountId));
        } else {
            $livestreamAccountId = $account;
        }
        if (empty($check_duplicate)) {
            $checkDuplicate = $this->confirm('Do you want to check duplicate by title and record date?', true);
        } else {
            $checkDuplicate = $check_duplicate;
        }

        $jobsCount = (new ImportEpisodesFromRssAction)->execute($rssFeedUrl, $livestreamAccountId, $checkDuplicate);

        $this->info($jobsCount . ' jobs are created!');
    }
}
