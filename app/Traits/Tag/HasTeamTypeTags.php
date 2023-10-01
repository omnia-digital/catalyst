<?php

namespace App\Traits\Tag;

trait HasTeamTypeTags
{
    public function teamTypes()
    {
        return $this->teamTypeTags();
    }

    public function teamTypeTags()
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable')
            ->where('type', 'team_type')
            ->ordered();
    }
}
