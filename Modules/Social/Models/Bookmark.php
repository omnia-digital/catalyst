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

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'order', 1: 'user_id', 2: 'bookmarkable_id', 3: 'bookmarkable_type'}
     */
    protected $fillable = [
        'order',
        'user_id',
        'bookmarkable_id',
        'bookmarkable_type'
    ];

    protected static function newFactory(): BookmarkFactory
    {
        return BookmarkFactory::new();
    }
}
