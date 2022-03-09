<?php

namespace Modules\Social\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Social\Database\Factories\BookmarkFactory;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'user_id',
        'bookmarkable_id',
        'bookmarkable_type'
    ];

    protected static function newFactory()
    {
        return BookmarkFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookmarkable()
    {
        return $this->morphTo();
    }
}
