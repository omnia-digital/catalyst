<?php

namespace Modules\Forms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Form extends Model
{
    use HasFactory, HasSlug;

    protected $casts = [
        'content' => 'array',
    ];

    protected $guarded = [];

    public static function getRegistrationForm()
    {
        return self::query()
            ->where('form_type_id', FormType::userRegistrationFormId())
            ->whereNotNull('form_type_id')
            ->first();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    // Attributes

    public function getIsActiveAttribute()
    {
        return ! is_null($this->published_at);
    }

    // Relationships

    public function formTemplate()
    {
        return $this->belongsTo(FormTemplate::class);
    }

    public function notifications()
    {
        return $this->hasMany(FormNotification::class);
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }

    public function formType()
    {
        return $this->belongsTo(FormType::class);
    }
}
