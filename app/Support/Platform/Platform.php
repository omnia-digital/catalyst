<?php

namespace App\Support\Platform;





use Nwidart\Modules\Facades\Module;

class Platform
{
    public function isModuleEnabled($moduleName): bool
    {
        $modules = collect(Module::allEnabled());

        $contains = $modules->contains(function ($value, $key) use ($moduleName) {
            return $moduleName === $value->getLowerName();
        });

        if ($contains) {
            return true;
        }

        return false;
    }

    public function translate($string): array|string|null
    {
        $wordsInString = explode(' ', $string);

        $newWordString = '';
        foreach ($wordsInString as $originalWord) {
            $lowercase   = strtolower($originalWord);
            $capitalized = ucfirst($originalWord);
            $singular    = \Str::singular($lowercase);
            $plural      = \Str::plural($lowercase);
            $newWord     = $lowercase;
            if (\Lang::has('platform_terms.' . $singular)) {
                $amount = 1;
                if ($lowercase == $plural) {
                    $amount = 2;
                }
                $newWord = trans_choice('platform_terms.' . $singular, $amount);
            }

            // Checks if first letter is capitalized of the original word
            if (ctype_upper(substr($originalWord, 0, 1))) {
                $newWord = ucfirst($newWord);
            } else {
                $newWord = strtolower($newWord);
            }

            $newWordString .= $newWord . ' ';
        }

        $newWordString = rtrim($newWordString);

        return __($newWordString);
    }
}
