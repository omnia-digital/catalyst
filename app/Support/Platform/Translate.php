<?php

namespace App\Support\Platform;

class Translate
{
    public function get($string): string
    {
        $wordsInString = explode(' ', $string);

        $newWordString = '';
        foreach($wordsInString as $originalWord) {
            $checkForPeriod = explode('.', $originalWord);
            if (!empty($checkForPeriod[1])) {
                $originalWord = $checkForPeriod[0];
                $period = $checkForPeriod[1];
            }
            $cleanedWord = $this->cleanWord($originalWord);
            $lowercase = strtolower($cleanedWord);
            $capitalized = ucfirst($cleanedWord);
            $singular = \Str::singular($lowercase);
            $plural = \Str::plural($lowercase);
            $newWord = $lowercase;
            if (\Lang::has('platform_terms.' . $singular) ) {
                $amount = 1;
                if ($lowercase == $plural) {
                    $amount = 2;
                }
                $newWord = trans_choice('platform_terms.' . $singular, $amount);
            }

            // Checks if first letter is capitalized of the original word
            if (ctype_upper(substr($cleanedWord,0,1))) {
                $newWord = ucfirst($newWord);
            } else {
                $newWord = strtolower($newWord);
            }

            $newWordString .= $newWord;
            if (!empty($period)) {
                $newWordString .= $period;
            }
            $newWordString .= ' ';
        }

        $newWordString = rtrim($newWordString);

        return __($newWordString);
    }

    private function cleanWord(string $originalWord)
    {
        return $originalWord;
        $cleanedWord = htmlspecialchars($originalWord, ENT_QUOTES, 'UTF-8');
        $cleanedWord = str_replace(['"', "'", '’',".", ",",";"], '', $cleanedWord);
        // @TODO [Josh] - currently we are just replacing punctuations, but we should be fining the position, then putting them back in at the exact same spot
        return $cleanedWord;
    }
}
