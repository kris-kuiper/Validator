<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\DeclinedNotEmpty as DeclinedNotEmptyRule;

class DeclinedNotEmpty extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return DeclinedNotEmptyRule::NAME;
    }
}
