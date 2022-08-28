<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\CountBetween as CountBetweenRule;

class CountBetween extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return CountBetweenRule::NAME;
    }
}
