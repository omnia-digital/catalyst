<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemedCoupon extends Model
{
    use HasFactory;

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'coupon_id', 1: 'code', 2: 'type', 3: 'original_price', 4: 'discount_amount', 5: 'after_discount_price', 6: 'redeemed_at'}
     */
    protected $fillable = [
        'coupon_id',
        'code',
        'type',
        'original_price',
        'discount_amount',
        'after_discount_price',
        'redeemed_at'
    ];

    /**
     * @var string[]
     *
     * @psalm-var array{redeemed_at: 'datetime'}
     */
    protected $casts = [
        'redeemed_at' => 'datetime'
    ];

    /**
     * @var false
     */
    public bool $timestamps = false;
}
