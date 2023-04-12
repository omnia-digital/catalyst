<?php

namespace App\Actions\Teams;

use App\Models\Tag;

class GetTeamCategoriesAction
{
    public function execute(): array
    {
        return Tag::withType('team')->get()->all();
//        ->mapWithKeys(fn(Tag $tag) => [$tag->name => ucwords($tag->name)])
    }
}
