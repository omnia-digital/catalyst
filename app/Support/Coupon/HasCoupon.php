<?php

namespace App\Support\Coupon;

use Illuminate\Database\Eloquent\Model;
use Modules\Jobs\Models\Coupon;
use Modules\Jobs\Models\RedeemedCoupon;

trait HasCoupon
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function redeemedCoupon()
    {
        return $this->morphOne(RedeemedCoupon::class, 'model');
    }

    /**
     * Redeem a coupon.
     *
     * @param $coupon
     * @param $originalPrice
     * @return Model
     */
    public function redeemCoupon($coupon, $originalPrice)
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
