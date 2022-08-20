<?php

namespace Modules\Reviews\Models;

use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Social\Traits\Likable;
use Modules\Social\Traits\Postable;

class Review extends Model
{
    use HasFactory, Postable, Likable;

    /**
     * @var array
     */
    protected array $guarded = [];

    /**
     * @var string[]
     *
     * @psalm-var array{received_product_free: 'boolean', recommend: 'boolean', commentable: 'boolean'}
     */
    protected array $casts = [
        'received_product_free' => 'boolean',
        'recommend' => 'boolean',
        'commentable' => 'boolean',
    ];
    
    protected static function newFactory(): \Modules\Reviews\Database\factories\ReviewFactory
    {
        return \Modules\Reviews\Database\factories\ReviewFactory::new();
    }
}
