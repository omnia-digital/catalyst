<?php

namespace Modules\Jobs\Rules;

use Modules\Jobs\Models\JobAddon;
use Illuminate\Contracts\Validation\Rule;

class ValidJobAddons implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_array($value)) {
            return false;
        }

        // Allows submit without add addons.
        if (count($value) === 0) {
            return true;
        }

        return JobAddon::whereIn('id', $value)->count() === count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please only select job addon from the list.';
    }
}
