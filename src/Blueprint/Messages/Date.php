<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Date as DateRule;

class Date extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DateRule::NAME;
    }
}
