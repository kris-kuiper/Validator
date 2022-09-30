<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\NegativeOrZero as NegativeOrZeroRule;

class NegativeOrZero extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return NegativeOrZeroRule::NAME;
    }
}
