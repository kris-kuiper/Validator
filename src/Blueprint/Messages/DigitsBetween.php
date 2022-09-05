<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\DigitsBetween as DigitsBetweenRule;

class DigitsBetween extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DigitsBetweenRule::NAME;
    }
}
