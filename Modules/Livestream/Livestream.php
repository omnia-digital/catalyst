<?php

namespace Modules\Livestream;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Modules\Livestream\Traits\UsesShortcodes;
use NumberFormatter;

class Livestream
{
    use UsesShortcodes;

    /**
     * @return string[][]
     */
    public static function bibleOptions(): array
    {
        return [
            [
                'code' => 'niv',
                'title' => 'NIV',
                'description' => '',
            ],
            [
                'code' => 'esv',
                'title' => 'ESV',
                'description' => '',
            ],
            [
                'code' => 'lbla95',
                'title' => 'Spanish (La Biblia de las Americas)',
                'description' => '',
            ],
        ];
    }

    /**
     * Humanize the given value into a proper name.
     *
     * @return string
     */
    public static function humanize($value)
    {
        if (is_object($value)) {
            return static::humanize(class_basename(get_class($value)));
        }

        return Str::title(Str::snake($value, ' '));
    }

    /**
     * @return mixed|string
     */
    public static function shortenLongNumber(mixed $number)
    {
        if ($number < 1000) {
            return $number;
        } elseif ($number > 1000 && $number < 1000000) {
            // Anything less than a million
            $formatted = number_format($number / 1000, 1) . 'K';
        } elseif ($number < 1000000000) {
            // Anything less than a billion
            $formatted = number_format($number / 1000000, 1) . 'M';
        } else {
            // At least a billion
            $formatted = number_format($number / 1000000000, 1) . 'B';
        }

        return $formatted;
    }

    /**
     * @return bool|string
     */
    public static function money(string $string, int $maxFractionDigits = 2)
    {
        $amount = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        $amount->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, $maxFractionDigits);

        return $amount->format($string);
    }

    /**
     * @param  string|null  $unit // Only support second and minute.
     */
    public static function formatDuration(int|float $duration, ?string $unit = null): string
    {
        is_null($unit) && $unit = config('metered.price.unit');

        if (! in_array($unit, ['second', 'minute'])) {
            throw new InvalidArgumentException('Only support "second" and "minute" for $unit.');
        }

        if ($unit === 'minute') {
            $duration = $duration * 60;
        }

        $duration = round($duration);

        return sprintf('%02d hours %02d minutes', ($duration / 3600), ($duration / 60 % 60));
    }

    /**
     * @return array
     */
    public static function extractFullName(string $fullName)
    {
        $name = explode(' ', $fullName);

        $firstName = $name[0];
        $lastName = count($name) === 1 ? '' : trim(str_replace($firstName, '', $fullName));

        return [$firstName, $lastName];
    }

    public static function adminEmails(): array
    {
        return [
            'josht@omnia-app.org',
            'admin@omnia-app.org',
            'phuc@omniadigital.io',
            'admin@omniadigital.io',
        ];
    }
}
