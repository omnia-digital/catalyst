<?php

namespace Modules\Games\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use MarcReichel\IGDBLaravel\Models\Cover;
use MarcReichel\IGDBLaravel\Models\Game as IGDBGame;
use MarcReichel\IGDBLaravel\Models\GameVideo;
use MarcReichel\IGDBLaravel\Models\InvolvedCompany;

class Game extends IGDBGame
{
    use HasFactory;

    public function getCoverUrlAttribute()
    {
        $coverUrl = Cover::where('id', $this->cover)->first()?->url;
        $coverUrl = Str::replaceFirst('thumb', 'cover_big', $coverUrl ?? '');

        return $coverUrl ?? 'https://via.placeholder.com/264x352';
    }

    public function getInvolvedCompaniesAttribute()
    {
        $companies = InvolvedCompany::where('game', $this->id)->get();

        return $companies;
    }

    public function getVideosAttribute()
    {
        $videos = GameVideo::where('game', $this->id)->get();

        return $videos;
    }

    public function getTrailerAttribute()
    {
        return $this->videos->first() ?? null;
    }
}
