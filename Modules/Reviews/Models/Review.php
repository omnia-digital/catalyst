<?php

namespace Modules\Reviews\Models;

use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Reviews\Database\factories\ReviewFactory;
use Modules\Social\Traits\Likable;
use Modules\Social\Traits\Postable;

class Review extends Model
{
    use HasFactory, Postable, Likable;

    protected $guarded = [];

    protected $casts = [
        'received_product_free' => 'boolean',
        'recommend' => 'boolean',
        'commentable' => 'boolean',
    ];

    protected static function newFactory()
    {
        return ReviewFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }
}
