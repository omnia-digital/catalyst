<?php

namespace Modules\Games\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Enums\Website\Category;
use MarcReichel\IGDBLaravel\Models\AgeRating;
use MarcReichel\IGDBLaravel\Models\Cover;
use MarcReichel\IGDBLaravel\Models\Game as IGDBGame;
use MarcReichel\IGDBLaravel\Models\GameVideo;
use MarcReichel\IGDBLaravel\Models\InvolvedCompany;
use MarcReichel\IGDBLaravel\Models\Website;

class Game extends IGDBGame
{
    use HasFactory;

    /**
     * @psalm-return \Illuminate\Support\Collection<empty, empty>
     */
    public function getVideos(): \Illuminate\Support\Collection
    {
        $videos = collect();
        if (!$this->videos) {
            return $videos;
        }
        foreach($this->videos as $video) {
            $videos->push(GameVideo::where('id', $video)->first());
        }

        return $videos;
    }

    public function getTrailer()
    {
        return $this->getVideos()->first() ?? null;
    }

    public function profile(): string
    {
        return route('games.show', $this->slug);
    }
}
