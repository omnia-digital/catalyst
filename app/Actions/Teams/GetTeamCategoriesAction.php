<?php

namespace App\Actions\Teams;

use App\Models\Tag;
use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class GetTeamCategoriesAction
{
    public function execute(): array
    {
        return Tag::withType('team')->get()->all();
//        ->mapWithKeys(fn(Tag $tag) => [$tag->name => ucwords($tag->name)])
    }
}
