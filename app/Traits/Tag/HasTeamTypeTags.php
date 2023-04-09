<?php

namespace App\Traits\Tag;

    trait HasTeamTypeTags
    {
        public function teamTypeTags()
        {
            return $this
                ->morphToMany(self::getTagClassName(), 'taggable')
                ->where('type', 'team_type')
                ->ordered();
        }

        public function teamTypes()
        {
            return $this->teamTypeTags();
        }
    }
