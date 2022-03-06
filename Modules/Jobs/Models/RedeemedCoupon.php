<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemedCoupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'code',
        'type',
        'original_price',
        'discount_amount',
        'after_discount_price',
        'redeemed_at'
    ];

    protected $casts = [
        'redeemed_at' => 'datetime'
    ];

    public $timestamps = false;

    public function model()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
