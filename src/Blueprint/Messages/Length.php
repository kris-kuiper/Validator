<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\Length as LengthRule;

class Length extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return LengthRule::NAME;
    }
}
