<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\MaxLength as MaxLengthRule;

class MaxLength extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return MaxLengthRule::NAME;
    }
}
