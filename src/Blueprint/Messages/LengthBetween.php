<?php

declare(strict_types=1);

namespace KrisKuiper\Validator\Blueprint\Messages;

use KrisKuiper\Validator\Blueprint\Rules\LengthBetween as LengthBetweenRule;

class LengthBetween extends AbstractMessage
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return LengthBetweenRule::NAME;
    }
}
