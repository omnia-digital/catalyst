<?php

namespace App\Util\Platform;

class Translate
{
    public function get($string, $amount = 1, $capitalized = true): string
    {
        $words = explode(' ', $string);

        $formattedString = '';
        foreach($words as $word) {
            $word = strtolower($word);
            $singular = \Str::singular($word);
            $plural = \Str::plural($word);
            if (\Lang::has('platform_terms.' . $singular) ) {
                if ($word == $plural) {
                    $amount = 2;
                }
                $word = trans_choice('platform_terms.' . $singular, $amount);
            }
            $word = $capitalized ? ucfirst($word) : $word;
            $formattedString .= $word . ' ';
        }

        $formattedString = rtrim($formattedString);

        return __($formattedString);
    }
}
