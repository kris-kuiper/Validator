<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Traits;

trait WordTrait
{
    /**
     * Returns all words defined by the minimum characters and if a word should only be alphanumeric found in a provided value
     */
    protected function filterWords(string|int|float $value, int $minCharacters = 2, bool $onlyAlphanumeric = true): array
    {
        $pattern = true === $onlyAlphanumeric ? '/^[a-zA-Z\d]{' . $minCharacters . ',}$/' : '/^(.*?){' . $minCharacters . ',}$/';
        $words = preg_split('/[ \n\r\t\v\x00]/', (string) $value);

        return array_filter($words, static function (string $word) use ($pattern) {
            return (bool) preg_match($pattern, $word);
        });
    }
}
