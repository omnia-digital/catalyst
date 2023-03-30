<?php

namespace Modules\Social\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class UserScoreContribution extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = ['name', 'slug', 'points'];
    
    protected static function newFactory()
    {
        return \Modules\Social\Database\factories\UserScoreContributionFactory::new();
    }

    public static function getPointsFor($slug)
    {
        $slug = Str::snake($slug);

        return self::where('slug', $slug)->first()->points;
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom('name')
                          ->saveSlugsTo('slug');
    }
}
