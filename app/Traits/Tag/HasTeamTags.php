<?php

namespace App\Traits\Tag;

    use Illuminate\Database\Eloquent\Relations\MorphToMany;

    trait HasTeamTags
    {
        public function teamTags()
        {
            return $this
                ->morphToMany(self::getTagClassName(), 'taggable')
                ->where('type', 'team')
                ->ordered();
        }

        public function tags(): MorphToMany
        {
            return $this->teamTags();
        }
    }
