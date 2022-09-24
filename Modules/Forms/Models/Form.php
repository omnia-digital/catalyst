<?php

namespace Modules\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Form extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'form_template_id',
        'team_id',
        'is_used_on_all_teams',
        'published_at'
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

    public function formTemplate()
    {
        return $this->belongsTo(FormTemplate::class);
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

}
