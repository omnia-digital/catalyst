<?php

namespace Modules\Reviews\Traits;

use App\Models\User;
use Modules\Reviews\Models\Review;

trait Reviewable
{
    
    /**
     * Get the model's reviews
     *
     * @psalm-return \Illuminate\Database\Eloquent\Relations\MorphMany<\Modules\Reviews\Models\Review>
     */
    public function reviews(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function reviewedBy(User $user): bool
    {
        return $this->reviews()->where('user_id', $user->id)->exists();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null
     *
     * @psalm-return TRelatedModel|null
     */
    public function getCurrentUserReview()
    {
        return $this->reviews()->where('user_id', auth()->id())->first() ?? null;
    }

    public function recommendedCount(): int
    {
        return $this->reviews()->where('recommend', 1)->count();
    }

}
