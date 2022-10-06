<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\DateBetween as DateBetweenRule;

class DateBetween extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DateBetweenRule::NAME;
    }
}
