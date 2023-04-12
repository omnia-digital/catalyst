<?php

namespace Modules\Games\Models\IGDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Models\AgeRating;
use MarcReichel\IGDBLaravel\Models\Cover;
use MarcReichel\IGDBLaravel\Models\Game as IGDBGame;
use MarcReichel\IGDBLaravel\Models\GameVideo;
use MarcReichel\IGDBLaravel\Models\InvolvedCompany;
use MarcReichel\IGDBLaravel\Models\Keyword;
use MarcReichel\IGDBLaravel\Models\Website;

class Game extends IGDBGame
{
    use HasFactory;

    public function getCoverUrl()
    {
        $coverUrl = Cover::where('id', $this->cover)->first()?->url;
        $coverUrl = $coverUrl ? Str::replaceFirst('thumb', 'cover_big', $coverUrl) : null;

        return $coverUrl ?? 'https://via.placeholder.com/264x352';
    }

    public function getInvolvedCompaniesAttribute()
    {
        $companies = InvolvedCompany::where('game', $this->id)->get();

        return $companies;
    }

    public function getVideos()
    {
        $videos = collect();
        if (! $this->videos) {
            return $videos;
        }
        foreach ($this->videos as $video) {
            $videos->push(GameVideo::where('id', $video)->first());
        }

        return $videos;
    }

    public function getTrailer()
    {
        return $this->getVideos()->first() ?? null;
    }

    public function getWebsitesAttribute()
    {
        return Website::where('game', $this->id)->get();
    }

    public function getRating()
    {
        return AgeRating::where('id', $this->rating)->first() ?? null;
    }

    public function profile()
    {
        return route('games.games.show', $this->slug);
    }

    public function getKeywordsAttribute()
    {
        $tags = $this->tags;

        return Keyword::where('');
    }
}
