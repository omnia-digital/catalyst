<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;

    const PERCENT = 'percent';
    const FIXED = 'fixed';

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    protected static function booted()
    {
        static::creating(fn(self $coupon) => $coupon->code = $coupon->code ?: Str::random());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function redeems()
    {
        return $this->hasMany(RedeemedCoupon::class);
    }

    /**
     * Find a coupon by its code.
     *
     * @param string $code
     * @return Coupon
     */
    public static function findByCode(string $code)
    {
        return self::where('code', $code)->first();
    }

    /**
     * Check if a coupon is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        if (!$this->expires_at) {
            return true;
        }

        if ($this->expires_at->lt(now())) {
            return false;
        }

        return true;
    }

    /**
     * Check if a coupon is used for a specific model.
     *
     * @param string|Model $model
     * @param int|null $id
     * @return bool
     */
    public function isRedeemedFor($model, ?int $id = null)
    {
        return RedeemedCoupon::query()
                             ->where('model_type', $model instanceof Model ? get_class($model) : $model)
                             ->where('model_id', $model instanceof Model ? $model->getKey() : $id)
                             ->exists();
    }

    /**
     * Calculate the price after discount.
     *
     * @param $originalPrice
     * @return float|int|mixed
     */
    public function afterDiscount($originalPrice)
    {
        return $originalPrice - $this->discountAmount($originalPrice);
    }

    /**
     * Calculate the discount amount.
     *
     * @param $originalPrice
     * @return float|int|mixed
     */
    public function discountAmount($originalPrice)
    {
        if ($this->type === static::PERCENT) {
            return $originalPrice * $this->discount / 100;
        }

        if ($this->type === static::FIXED) {
            return $this->discount;
        }

        return 0;
    }
}
