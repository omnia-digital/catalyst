<?php

namespace Modules\Livestream\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    protected $dates = [
        'dob',
    ];

    public static function findByName(string $firstName, string $lastName): ?self
    {
        return self::query()
            ->where('first_name', $firstName)
            ->where('last_name', $lastName)
            ->first();
    }

    public function getPhotoAttribute()
    {
        // @TODO [Josh] - this code is causing an infinite loop
//        if ($this->user && !$this->user->profile_photo_url) {
//            return $this->user->profile_photo_url;
//        } else {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
//        }
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_person');
    }

    public function scopeSearch(Builder $query, ?string $terms)
    {
        collect(explode(' ', $terms))
            ->filter()
            ->each(function (string $term) use ($query) {
                $term = '%' . $term . '%';

                $query->where(function (Builder $query) use ($term) {
                    $query->where('first_name', 'like', $term)
                        ->orWhere('last_name', 'like', $term);
                });
            });
    }
}
