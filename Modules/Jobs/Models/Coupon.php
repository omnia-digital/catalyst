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

    /**
     * @var string[]
     *
     * @psalm-var array{expires_at: 'datetime'}
     */
    protected $casts = [
        'expires_at' => 'datetime'
    ];

    protected static function booted()
    {
        static::creating(fn(self $coupon) => $coupon->code = $coupon->code ?: Str::random());
    }

    /**
     * Find a coupon by its code.
     *
     * @param string $code
     *
     * @return null|static
     *
     * @psalm-return null|static&\Illuminate\Database\Eloquent\Builder<static>
     */
    public static function findByCode(string $code): static|null
    {
        return self::where('code', $code)->first();
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
