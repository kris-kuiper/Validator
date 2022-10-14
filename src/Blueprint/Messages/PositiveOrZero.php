<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\PositiveOrZero as PositiveOrZeroRule;

class PositiveOrZero extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return PositiveOrZeroRule::NAME;
    }
}
