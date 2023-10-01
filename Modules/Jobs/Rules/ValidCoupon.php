<?php

namespace Modules\Jobs\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Jobs\Models\Coupon;

class ValidCoupon implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $coupon = Coupon::findByCode($value);

        if (! $coupon) {
            return false;
        }

        return $coupon->isValid();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The coupon is invalid or expired.';
    }
}
