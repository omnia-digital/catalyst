<?php

namespace App\Traits\Tag;

    trait InteractsWithTopic
    {
        public function syncTopics(string|array|null $topics): void
        {
            if (empty($topics)) {
                return;
            }

            is_string($topics) && $topics = explode(',', $topics);

            $this->syncTagsWithType(array_map('trim', $topics), 'topic');
        }
    }
