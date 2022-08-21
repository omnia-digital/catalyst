<?php

namespace App\Traits\Coupon;

use Illuminate\Database\Eloquent\Model;
use Modules\Jobs\Models\Coupon;
use Modules\Jobs\Models\RedeemedCoupon;

trait HasCoupon
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     *
     * @psalm-return \Illuminate\Database\Eloquent\Relations\MorphOne<\Modules\Jobs\Models\RedeemedCoupon>
     */
    public function redeemedCoupon(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(RedeemedCoupon::class, 'model');
    }

    /**
     * Redeem a coupon.
     *
     * @param $coupon
     * @param $originalPrice
     */
    public function redeemCoupon($coupon, $originalPrice): \Modules\Jobs\Models\RedeemedCoupon
    {
        $coupon = $coupon instanceof Coupon ? $coupon : Coupon::findByCode($coupon);

        if (!$coupon) {
            throw new \LogicException('Coupon is not found');
        }

        return $this->redeemedCoupon()->create([
                                                   'coupon_id'            => $coupon->id,
                                                   'code'                 => $coupon->code,
                                                   'type'                 => $coupon->type,
                                                   'original_price'       => $originalPrice,
                                                   'discount_amount'      => $coupon->discountAmount($originalPrice),
                                                   'after_discount_price' => $coupon->afterDiscount($originalPrice),
                                                   'redeemed_at'          => now()
                                               ]);
    }
}
