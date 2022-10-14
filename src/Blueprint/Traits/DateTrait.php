<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Traits;

use DateTime;
use KrisKuiper\Validator\Exceptions\ValidatorException;

trait DateTrait
{
    /**
     * Returns a date instance created from string and format
     * @throws ValidatorException
     */
    protected function createDate(string $date, string $format = 'Y-m-d'): DateTime
    {
        $d = DateTime::createFromFormat($format, $date);

        if (false === $d || $d->format($format) !== $date) {
            throw ValidatorException::incorrectDateFormatUsed($date, $format);
        }

        return $d;
    }
}
