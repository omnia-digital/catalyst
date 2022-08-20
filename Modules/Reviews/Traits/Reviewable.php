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

    public function reviewedBy(User $user)
    {
        return $this->reviews()->where('user_id', $user->id)->exists();
    }

    public function getCurrentUserReview()
    {
        return $this->reviews()->where('user_id', auth()->id())->first() ?? null;
    }

    public function recommendedCount()
    {
        return $this->reviews()->where('recommend', 1)->count();
    }

}
