<?php

namespace Modules\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class FormTemplate extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [
        'content' => 'array',
    ];

    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->generateSlugsFrom('name')
                          ->saveSlugsTo('slug')
                          ->doNotGenerateSlugsOnUpdate();
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
    }
}
